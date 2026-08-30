import React, { useEffect, useRef, useState } from 'react';

const TRANSITION_FLAG = '__simskul_loading';
const NAV_EVENT = 'simskul:navigate';
const MIN_DISPLAY = 250;
const SAFE_MAX = 2500;

function debugLog(...args) {
    try {
        if (window.__simskulDebug) console.log('[LoadingOverlay]', ...args);
    } catch (e) {}
}

export default function LoadingOverlay() {
    const [visible, setVisible] = useState(true);
    const [fading, setFading] = useState(false);
    const timersRef = useRef([]);
    const shownRef = useRef(false);

    const clearTimers = () => {
        timersRef.current.forEach((t) => clearTimeout(t));
        timersRef.current = [];
    };

    const hide = () => {
        if (!shownRef.current) return;
        shownRef.current = false;
        clearTimers();
        setFading(true);
        timersRef.current.push(
            setTimeout(() => {
                setVisible(false);
                setFading(false);
            }, 350)
        );
    };

    const show = () => {
        shownRef.current = true;
        clearTimers();
        setFading(false);
        setVisible(true);
        timersRef.current.push(setTimeout(hide, SAFE_MAX));
    };

    useEffect(() => {
        let fromTransition = false;
        try {
            fromTransition = sessionStorage.getItem(TRANSITION_FLAG) === '1';
            sessionStorage.removeItem(TRANSITION_FLAG);
        } catch (e) {}
        debugLog('mounted, fromTransition =', fromTransition);

        const onLoad = () => {
            debugLog('window load fired');
            hide();
        };
        const onNavigate = () => {
            debugLog('navigate event');
            show();
        };

        // On a direct (non-transition) page load, show the overlay only briefly
        // so it feels fast and never blocks. On navigation, keep it until the
        // new page's resources finish loading.
        shownRef.current = true;
        setVisible(true);
        timersRef.current.push(setTimeout(hide, fromTransition ? SAFE_MAX : MIN_DISPLAY));

        window.addEventListener('load', onLoad);
        window.addEventListener(NAV_EVENT, onNavigate);
        if (document.readyState === 'complete') {
            onLoad();
        }

        return () => {
            clearTimers();
            window.removeEventListener('load', onLoad);
            window.removeEventListener(NAV_EVENT, onNavigate);
        };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    if (!visible) return null;

    return (
        <div
            className={`simskul-loading ${fading ? 'simskul-loading--done' : ''}`}
            role="status"
            aria-label="Loading"
        >
            <div className="simskul-loading__box">
                <div className="simskul-loading__spinner"></div>
                <div className="simskul-loading__title">Loading</div>
                <div className="simskul-loading__sub">Mohon Tunggu</div>
            </div>
        </div>
    );
}
