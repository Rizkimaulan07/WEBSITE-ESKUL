import React, { useEffect, useRef, useState } from 'react';

const TRANSITION_FLAG = '__simskul_loading';
const NAV_EVENT = 'simskul:navigate';
const MIN_DISPLAY = 900;

function debugLog(...args) {
    try {
        if (window.__simskulDebug) console.log('[LoadingOverlay]', ...args);
    } catch (e) {}
}

export default function LoadingOverlay() {
    const [visible, setVisible] = useState(true);
    const [fading, setFading] = useState(false);
    const timersRef = useRef([]);

    const clearTimers = () => {
        timersRef.current.forEach((t) => clearTimeout(t));
        timersRef.current = [];
    };

    const show = () => {
        clearTimers();
        setFading(false);
        setVisible(true);
    };

    const finish = () => {
        setFading(true);
        timersRef.current.push(
            setTimeout(() => {
                setVisible(false);
                setFading(false);
            }, 350)
        );
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
            finish();
        };
        const onNavigate = () => {
            debugLog('navigate event');
            show();
        };
        const minTimer = setTimeout(finish, fromTransition ? 400 : MIN_DISPLAY);
        timersRef.current.push(minTimer);

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