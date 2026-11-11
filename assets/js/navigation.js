/**
 * Sharji Press - Navigation & Search
 * Handles mobile drawer menus and debounced live search
 */

function sharjiToggleMenu() {
    var panel = document.getElementById('sharjiPanel');
    var overlay = document.getElementById('sharjiOverlay');

    if (!panel || !overlay) return;

    panel.classList.toggle('open');
    overlay.classList.toggle('show');
    document.body.classList.toggle('no-scroll');
}

function toggleSportMenu() {
    var panel = document.getElementById('sportPanel') || document.getElementById('mobile-menu');
    var overlay = document.getElementById('sportOverlay') || document.getElementById('mobile-menu-overlay');

    if (!panel || !overlay) return;

    if (panel.id === 'mobile-menu') {
        if (panel.classList.contains('translate-x-full')) {
            panel.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(function() { overlay.classList.remove('opacity-0'); }, 10);
        } else {
            panel.classList.add('translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(function() { overlay.classList.add('hidden'); }, 300);
        }
    } else {
        panel.classList.toggle('open');
        overlay.classList.toggle('show');
        document.body.classList.toggle('no-scroll');
    }
}

// Alias for footer-sport
var toggleMenu = toggleSportMenu;

document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('sharjiSearchInput');
    var results = document.getElementById('sharjiLiveResults');

    if (!input || !results) return;

    var debounceTimer = null;
    var restBase = (typeof sharjiSettings !== 'undefined' && sharjiSettings.homeUrl) 
        ? sharjiSettings.homeUrl 
        : window.location.origin;

    input.addEventListener('input', function(e) {
        var term = e.target.value.trim();

        clearTimeout(debounceTimer);

        if (term.length < 2) {
            results.innerHTML = '';
            results.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(async function() {
            try {
                var response = await fetch(restBase + '/wp-json/wp/v2/posts?search=' + encodeURIComponent(term) + '&per_page=5&_fields=id,title,link');
                var posts = await response.json();

                if (Array.isArray(posts) && posts.length > 0) {
                    var html = '';
                    posts.forEach(function(post) {
                        var title = (post.title && post.title.rendered) ? post.title.rendered : '';
                        html += '<a href="' + post.link + '">' + title + '</a>';
                    });
                    results.innerHTML = html;
                    results.style.display = 'block';
                } else {
                    results.innerHTML = '<div style="padding:12px; font-size:12px; color:#64748b;">موردی یافت نشد.</div>';
                    results.style.display = 'block';
                }
            } catch(err) {
                results.innerHTML = '<div style="padding:12px; font-size:12px; color:#e31e24;">خطا در جستجو</div>';
                results.style.display = 'block';
            }
        }, 260);
    });

    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !results.contains(e.target)) {
            results.style.display = 'none';
        }
    });
});
