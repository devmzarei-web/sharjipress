/**
 * Sharji Sport - Hub Interactivity
 * Tabs switching, mobile AJAX load more, and sport sliders
 */

const sportPageCounters = {
    latest: 1,
    headlines: 1,
    sidebar: 1
};

function toggleSportTabs(evt, groupName, contentId) {
    let tabSelector = groupName === 'sport-group1' ? '.sport-group-1-tab' : '.sport-group-2-tab';
    let contentSelector = groupName === 'sport-group1' ? '.sport-group1-content' : '.sport-group2-content';

    document.querySelectorAll(tabSelector).forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll(contentSelector).forEach(c => c.classList.add('hidden'));

    evt.currentTarget.classList.add('active');
    var targetEl = document.getElementById(contentId);
    if (targetEl) {
        targetEl.classList.remove('hidden');
    }

    let btn = document.getElementById(evt.currentTarget.getAttribute('data-btn'));
    let slug = evt.currentTarget.getAttribute('data-slug');

    if (btn) {
        if (slug === 'table') {
            btn.style.display = 'none';
        } else {
            btn.style.display = 'flex';
            btn.innerHTML = '<i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر';
            btn.disabled = false;
        }
    }
}

function loadMoreSportMobile(btnId, groupName) {
    const btn = document.getElementById(btnId);
    let activeTab = document.querySelector(groupName === 'sport-group1' ? '.sport-group-1-tab.active' : '.sport-group-2-tab.active');
    if (!activeTab || !btn) return;

    const slug = activeTab.getAttribute('data-slug');

    if (slug === 'table') {
        btn.style.display = 'none';
        return;
    }

    const listContainerId = 'sport-list-' + slug;
    const listContainer = document.getElementById(listContainerId);

    if (!listContainer) return;

    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال دریافت...';

    let nextPage = (sportPageCounters[slug] || 1) + 1;

    const formData = new FormData();
    formData.append('action', 'load_more_mobile_action');
    formData.append('page', nextPage);
    formData.append('type', 'sport');

    var ajaxUrl = (typeof sharjiSettings !== 'undefined' && sharjiSettings.ajaxUrl) 
        ? sharjiSettings.ajaxUrl 
        : '/wp-admin/admin-ajax.php';

    fetch(ajaxUrl, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success && data.data.html) {
            listContainer.insertAdjacentHTML('beforeend', data.data.html);
            sportPageCounters[slug] = nextPage;
            btn.innerHTML = '<i class="fas fa-plus-circle"></i> مشاهده اخبار بیشتر';
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

document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper === 'undefined') return;

    if (document.querySelector(".hero-swiper")) {
        new Swiper(".hero-swiper", {
            direction: "vertical",
            slidesPerView: 1,
            spaceBetween: 0,
            speed: 800,
            loop: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            allowTouchMove: false,
        });
    }

    if (document.querySelector(".sport-mobile-slider")) {
        new Swiper(".sport-mobile-slider", {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    }
});

