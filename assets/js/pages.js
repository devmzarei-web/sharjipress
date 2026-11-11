/**
 * Sharji Press - Custom Pages Logic
 * Newspaper modal, Prayer times timer & search, Frontend editor placeholders, Ad links target
 */

// 1. Newspaper Modal Lightbox
function openNewspaperModal(imgSrc, title) {
    const modal = document.getElementById('npImgModal') || document.getElementById('newspaperModal');
    const modalImg = document.getElementById('npModalImage') || document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    
    if (!modal || !modalImg) return;

    modalImg.src = imgSrc;
    if (modalTitle && title) modalTitle.innerText = title;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeNewspaperModal() {
    const modal = document.getElementById('npImgModal') || document.getElementById('newspaperModal');
    if (!modal) return;
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
}

document.addEventListener('keydown', function(event) { 
    if (event.key === "Escape") closeNewspaperModal(); 
});

document.addEventListener('DOMContentLoaded', function() {
    // 2. Ad Links in Pages / Index
    const adLinks = document.querySelectorAll('#index-clean-ads a');
    adLinks.forEach(function(link) {
        link.setAttribute('target', '_blank');
        link.setAttribute('rel', 'noopener noreferrer');
    });

    // 3. Frontend News Editor Placeholders (ACF)
    const titleInput = document.querySelector('.acf-field[data-name="_post_title"] input');
    if (titleInput) titleInput.setAttribute('placeholder', 'عنوان خبر را اینجا تایپ کنید...');

    const excerptInput = document.querySelector('.acf-field[data-name="frontend_excerpt"] textarea');
    if (excerptInput) excerptInput.setAttribute('placeholder', 'چکیده یا خلاصه خبر را در این کادر بنویسید...');

    const videoInput = document.querySelector('.acf-field[data-name="video_preview_url"] input');
    if (videoInput) videoInput.setAttribute('placeholder', 'https://example.com/video.mp4');

    // 4. Prayer Times City Search
    const citySearch = document.getElementById('citySearch');
    const cityList = document.getElementById('cityList');
    if (citySearch && cityList) {
        citySearch.addEventListener('keyup', function() {
            let input = this.value.toLowerCase();
            let links = cityList.getElementsByTagName('a');
            for (let i = 0; i < links.length; i++) {
                let span = links[i].getElementsByTagName('span')[0];
                if (span && span.innerHTML.toLowerCase().indexOf(input) > -1) {
                    links[i].style.display = 'flex';
                } else {
                    links[i].style.display = 'none';
                }
            }
        });
    }

    // 5. Prayer Times Countdown Timer
    const boxes = document.querySelectorAll('.sh-box');
    if (boxes.length > 0) {
        function toFarsiJS(str) {
            return str.toString().replace(/\d/g, function(d) { return "۰۱۲۳۴۵۶۷۸۹"[d]; });
        }
        function toEnglishDigits(str) {
            return str.toString().replace(/[۰-۹]/g, function(d) { return "۰۱۲۳۴۵۶۷۸۹".indexOf(d); });
        }

        function updatePrayerTimer() {
            const now = new Date();
            const tehranTime = new Intl.DateTimeFormat('en-US', {
                timeZone: 'Asia/Tehran',
                hour: 'numeric', minute: 'numeric', second: 'numeric',
                hour12: false
            });
            
            const parts = tehranTime.formatToParts(now);
            const h = parseInt(parts.find(p => p.type === 'hour').value);
            const m = parseInt(parts.find(p => p.type === 'minute').value);
            const s = parseInt(parts.find(p => p.type === 'second').value);
            const curSeconds = h * 3600 + m * 60 + s;
            
            let nextEvent = null;
            let minDiff = Infinity; 
            let firstEventOfDay = null;

            boxes.forEach((box, index) => {
                let rawTime = box.getAttribute('data-time');
                if (!rawTime || rawTime === '--:--' || rawTime === '00:00' || rawTime === '۰۰:۰۰') return;
                
                let timeStr = toEnglishDigits(rawTime);
                let [th, tm] = timeStr.split(':').map(Number);
                if (isNaN(th) || isNaN(tm)) return;
                
                if (index === 5 && th < 4) { th += 24; }
                const eventSeconds = th * 3600 + tm * 60;
                
                if (index === 0) { 
                    firstEventOfDay = { el: box, label: box.getAttribute('data-label'), seconds: eventSeconds }; 
                }
                
                let diff = eventSeconds - curSeconds;
                if (diff > 0 && diff < minDiff) {
                    minDiff = diff;
                    nextEvent = { el: box, label: box.getAttribute('data-label'), diff: diff };
                }
            });

            if (!nextEvent && firstEventOfDay) {
                let tomorrowDiff = (firstEventOfDay.seconds + 86400) - curSeconds;
                nextEvent = { el: firstEventOfDay.el, label: firstEventOfDay.label, diff: tomorrowDiff };
            }

            const countdownBox = document.getElementById('countdown-box');
            const labelEl = document.getElementById('next-event-label');
            const timerEl = document.getElementById('next-event-timer');
            
            boxes.forEach(b => b.classList.remove('active'));

            if (nextEvent && countdownBox && labelEl && timerEl) {
                nextEvent.el.classList.add('active');
                countdownBox.style.display = 'inline-block';
                labelEl.innerText = 'مانده تا ' + nextEvent.label;
                
                let hours = Math.floor(nextEvent.diff / 3600);
                let minutes = Math.floor((nextEvent.diff % 3600) / 60);
                let seconds = Math.floor(nextEvent.diff % 60);
                
                let timeString = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
                timerEl.innerText = toFarsiJS(timeString);
            } else if (countdownBox) {
                countdownBox.style.display = 'none';
            }
        }

        let hasData = false;
        boxes.forEach(box => {
            let time = box.getAttribute('data-time');
            if (time && time !== '--:--' && time !== '00:00' && time !== '۰۰:۰۰') {
                hasData = true;
            }
        });

        if (hasData) {
            setInterval(updatePrayerTimer, 1000);
            updatePrayerTimer();
        }
    }
});
