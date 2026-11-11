/**
 * Sharji Press - Homepage Interactivity
 * Live view counter, tab switching, sliders, mobile/desktop load more, and corner popups
 */

const pageCounters = { 'news': 1, 'tahlil': 1, 'most_viewed': 1, 'video': 1, 'interviews': 1 };
let currSlide = 0;

function getSharjiAjaxUrl() {
    return (typeof sharjiSettings !== 'undefined' && sharjiSettings.ajaxUrl) 
        ? sharjiSettings.ajaxUrl 
        : '/wp-admin/admin-ajax.php';
}

function updateLiveViewCounts() {
    var elements = document.querySelectorAll('.live-view-count');
    if (elements.length === 0) return;
    
    var postIds = [];
    elements.forEach(function(el) {
        var id = el.getAttribute('data-id');
        if (id && postIds.indexOf(id) === -1) postIds.push(id);
    });
    
    if (postIds.length === 0) return;

    var formData = new FormData();
    formData.append('action', 'sharji_get_bulk_views');
    postIds.forEach(function(id) { 
        formData.append('post_ids[]', id); 
    });
    
    fetch(getSharjiAjaxUrl(), {
        method: 'POST',
        body: formData
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data.success && data.data) {
            elements.forEach(function(el) {
                var id = el.getAttribute('data-id');
                if (data.data[id] !== undefined) {
                    el.textContent = data.data[id];
                }
            });
        }
    }).catch(function(err) { console.error(err); });
}

function toggleTabs(evt, groupName, contentId) {
    let tabSelector = groupName === 'group1' ? '.group-1-tab' : '.group-2-tab';
    let contentSelector = groupName === 'group1' ? '.group1-content' : '.group2-content';

    document.querySelectorAll(tabSelector).forEach(btn => btn.classList.remove("active"));
    document.querySelectorAll(contentSelector).forEach(c => c.classList.add("hidden"));

    evt.currentTarget.classList.add("active");
    var targetContent = document.getElementById(contentId);
    if (targetContent) {
        targetContent.classList.remove("hidden");
    }

    var btn = document.getElementById(evt.currentTarget.getAttribute('data-btn'));
    if (btn) {
        btn.innerHTML = '<i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر';
        btn.disabled = false;
    }
}

function showSlide(index) {
    const slider = document.getElementById('main-slider');
    if (!slider) return;

    const slides = slider.children;
    if (index >= slides.length) currSlide = 0;
    else if (index < 0) currSlide = slides.length - 1;
    else currSlide = index;

    slider.style.transform = 'translateX(' + (currSlide * 100) + '%)';
}

function nextSlide() {
    showSlide(currSlide + 1);
}

function prevSlide() {
    showSlide(currSlide - 1);
}

function loadMoreMobile(btnId, groupName) {
    const btn = document.getElementById(btnId);
    if (!btn) return;

    let tabSelector = groupName === 'group1' ? '.group-1-tab.active' : '.group-2-tab.active';
    const activeTab = document.querySelector(tabSelector);
    if (!activeTab) return;

    const slug = activeTab.getAttribute('data-slug');
    const listContainerId = 'list-' + slug;

    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال دریافت...';

    let nextPage = pageCounters[slug] + 1;

    const formData = new FormData();
    formData.append('action', 'load_more_mobile_action');
    formData.append('page', nextPage);
    formData.append('type', slug);

    fetch(getSharjiAjaxUrl(), {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            var container = document.getElementById(listContainerId);
            if (container) {
                container.insertAdjacentHTML('beforeend', data.data.html);
            }
            pageCounters[slug]++;
            btn.innerHTML = '<i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر';
            updateLiveViewCounts();
        } else {
            btn.innerHTML = 'اخبار بیشتری نیست';
            btn.disabled = true;
        }
    })
    .catch(err => {
        console.error(err);
        btn.innerHTML = 'خطا در ارتباط';
    });
}

function setupCornerPopup(id) {
    var popup = document.getElementById(id);
    if (!popup) return;

    setTimeout(function() {
        popup.classList.add('is-active');
    }, 1500);
}

function closeCornerPopup(id) {
    var popup = document.getElementById(id);
    if (!popup) return;

    popup.classList.remove('is-active');
}

function initSharjiHome() {
    // Slider timer
    if (document.getElementById('main-slider')) {
        setInterval(nextSlide, 8000);
    }
    
    updateLiveViewCounts();

    // Desktop Global Load More
    let page = 1;
    const loadBtn = document.getElementById('global-load-more');

    if (loadBtn) {
        loadBtn.addEventListener('click', function() {
            loadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال بارگذاری...';

            const formData = new FormData();
            formData.append('action', 'load_more_home_action');
            formData.append('page', page);

            fetch(getSharjiAjaxUrl(), {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data) {
                    if (data.data.most_viewed && document.getElementById('most-viewed-list')) {
                        document.getElementById('most-viewed-list').insertAdjacentHTML('beforeend', data.data.most_viewed);
                    }
                    if (data.data.latest && document.getElementById('latest-news-center-list')) {
                        document.getElementById('latest-news-center-list').insertAdjacentHTML('beforeend', data.data.latest);
                    }
                    if (data.data.interviews && document.getElementById('interviews-list')) {
                        document.getElementById('interviews-list').insertAdjacentHTML('beforeend', data.data.interviews);
                    }

                    page++;
                    loadBtn.innerHTML = '<i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر';
                    updateLiveViewCounts();
                }
            })
            .catch(err => {
                console.error(err);
                loadBtn.innerHTML = '<i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر';
            });
        });
    }

    // Corner Popups
    setupCornerPopup('popupRight');
    setupCornerPopup('popupLeft');
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSharjiHome);
} else {
    initSharjiHome();
}

// Hover-to-Play Logic for Video Previews (Supports AJAX)
document.addEventListener('mouseover', function(e) {
    const card = e.target.closest('.n-box, .m-news-row, .special-row');
    if (card) {
        const vid = card.querySelector('video');
        if (vid && vid.paused) {
            vid.play().catch(function() {});
        }
    }
});

document.addEventListener('mouseout', function(e) {
    const card = e.target.closest('.n-box, .m-news-row, .special-row');
    if (card) {
        const vid = card.querySelector('video');
        if (vid && !card.contains(e.relatedTarget)) {
            vid.pause();
            vid.currentTime = 0;
        }
    }
});

