import React from 'react';
import { createRoot } from 'react-dom/client';
import LoadingOverlay from './LoadingOverlay';

const TRANSITION_FLAG = '__simskul_loading';

const rootEl = document.getElementById('loadingOverlayRoot');

if (rootEl) {
    createRoot(rootEl).render(<LoadingOverlay />);
}

function markTransition() {
    try {
        sessionStorage.setItem(TRANSITION_FLAG, '1');
    } catch (e) {}
    window.dispatchEvent(new Event('simskul:navigate'));
}

function isInternalLink(anchor) {
    const href = (anchor.getAttribute('href') || '').trim();
    if (!href) return false;
    if (href.startsWith('#') || href.startsWith('javascript:')) return false;
    if (href.startsWith('mailto:') || href.startsWith('tel:')) return false;
    if (anchor.target && anchor.target.toLowerCase() !== '_self') return false;
    if (anchor.hasAttribute('download')) return false;
    if (anchor.getAttribute('data-no-loader') !== null) return false;
    if (href.startsWith('http://') || href.startsWith('https://')) {
        try {
            const url = new URL(href);
            if (url.origin !== window.location.origin) return false;
        } catch (e) {
            return false;
        }
    }
    return true;
}

function isNavigation(form) {
    if (form.target && form.target !== '_self') return false;
    if (form.getAttribute('data-no-loader') !== null) return false;
    return true;
}

document.addEventListener('click', (e) => {
    const anchor = e.target.closest('a[href]');
    if (!anchor || !isInternalLink(anchor)) return;

    const url = new URL(anchor.href);
    const samePage =
        url.pathname === window.location.pathname &&
        url.search === window.location.search &&
        url.hash === '';
    if (samePage) return;

    e.preventDefault();
    markTransition();
    window.location.href = anchor.href;
});

document.addEventListener('submit', (e) => {
    const form = e.target;
    if (!form || form.tagName !== 'FORM' || !isNavigation(form)) return;
    markTransition();
});