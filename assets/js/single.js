/**
 * Sharji Press - Single Post Actions
 * Font size adjustment, copy to clipboard, native Web Share API
 * Supports both standard single and sport single templates
 */

function adjustFont(amount) {
    var content = document.getElementById('mainContent');
    if (!content) return;

    var currentSize = parseFloat(window.getComputedStyle(content, null).getPropertyValue('font-size'));
    var newSize = currentSize + amount;

    if (newSize >= 14 && newSize <= 30) {
        content.style.fontSize = newSize + 'px';
        content.style.lineHeight = (newSize * 1.85) + 'px';
    }
}

function sharjiCopyText(text) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(function() {
            sharjiShowCopyStatus();
        }).catch(function() {
            sharjiFallbackCopy(text);
        });
    } else {
        sharjiFallbackCopy(text);
    }
}

function sharjiFallbackCopy(text) {
    var tempInput = document.createElement('input');
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    try {
        document.execCommand('copy');
    } catch(e) {}
    document.body.removeChild(tempInput);
    sharjiShowCopyStatus();
}

function sharjiCopyShortlink() {
    var input = document.getElementById('sharjiShortlinkInput') || document.getElementById('sportShortlinkInput');
    if (!input) return;
    sharjiCopyText(input.value);
}

function sharjiShowCopyStatus() {
    var status = document.getElementById('sharjiCopyStatus') || document.getElementById('sportCopyStatus');
    if (!status) return;

    status.style.display = 'inline-block';

    setTimeout(function() {
        status.style.display = 'none';
    }, 1800);
}

function sharjiNativeShare(title, url) {
    if (navigator.share) {
        navigator.share({
            title: title,
            text: title,
            url: url
        }).catch(function() {});
    } else {
        sharjiCopyText(url);
    }
}

// Aliases for sport single template
var sportCopyText = sharjiCopyText;
var sportFallbackCopy = sharjiFallbackCopy;
var sportCopyShortlink = sharjiCopyShortlink;
var sportShowCopyStatus = sharjiShowCopyStatus;
var sportNativeShare = sharjiNativeShare;

