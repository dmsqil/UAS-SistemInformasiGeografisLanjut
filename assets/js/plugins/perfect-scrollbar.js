/*!
 * perfect-scrollbar v1.5.1
 * Copyright 2020 Hyunje Jun, MDBootstrap and Contributors
 * Licensed under MIT
 */ (function (a, b) {
  "object" == typeof exports && "undefined" != typeof module ? (module.exports = b()) : "function" == typeof define && define.amd ? define(b) : ((a = a || self), (a.PerfectScrollbar = b()));
})(this, function () {
    "use strict";
    var u = Math.abs,
        v = Math.floor;
    function a(a) {
        return getComputedStyle(a);
    }
    function b(a, b) {
        for (var c in b) {
            var d = b[c];
            "number" == typeof d && (d += "px"), (a.style[c] = d);
        }
        return a;
    }
    function c(a) {
        var b = document.createElement("div");
        return (b.className = a), b;
    }
    function d(a, b) {
        if (!w) throw new Error("No element matching method supported");
        return w.call(a, b);
    }
    function e(a) {
        a.remove ? a.remove() : a.parentNode && a.parentNode.removeChild(a);
    }
    function f(a, b) {
        return Array.prototype.filter.call(a.children, function (a) {
            return d(a, b);
        });
    }
    function g(a, b) {
        var c = a.element.classList,
            d = z.state.scrolling(b);
        c.contains(d) ? clearTimeout(A[b]) : c.add(d);
    }
    function h(a, b) {
        A[b] = setTimeout(function () {
            return a.isAlive && a.element.classList.remove(z.state.scrolling(b));
        }, a.settings.scrollingThreshold);
    }
    function j(a, b) {
        g(a, b), h(a, b);
    }
    function k(a) {
        if ("function" == typeof window.CustomEvent) return new CustomEvent(a);
        var b = document.createEvent("CustomEvent");
        return b.initCustomEvent(a, !1, !1, void 0), b;
    }
    function l(a, b, c, d, e) {
        void 0 === d && (d = !0), void 0 === e && (e = !1);
        var f;
        if ("top" === b) f = ["contentHeight", "containerHeight", "scrollTop", "y", "up", "down"];
        else if ("left" === b) f = ["contentWidth", "containerWidth", "scrollLeft", "x", "left", "right"];
        else throw new Error("A proper axis should be provided");
        m(a, c, f, d, e);
    }
    function m(a, b, c, d, e) {
        var f = c[0],
            g = c[1],
            h = c[2],
            i = c[3],
            l = c[4],
            m = c[5];
        void 0 === d && (d = !0), void 0 === e && (e = !1);
        var n = a.element; // reset reach
        (a.reach[i] = null),
            1 > n[h] && (a.reach[i] = "start"),
            n[h] > a[f] - a[g] - 1 && (a.reach[i] = "end"),
            b && (n.dispatchEvent(k("ps-scroll-" + i)), 0 > b ? n.dispatchEvent(k("ps-scroll-" + l)) : 0 < b && n.dispatchEvent(k("ps-scroll-" + m)), d && j(a, i)),
            a.reach[i] && (b || e) && n.dispatchEvent(k("ps-" + i + "-reach-" + a.reach[i]));
    }
    function n(a) {
        return parseInt(a, 10) || 0;
    }
    function o(a) {
        return d(a, "input,[contenteditable]") || d(a, "select,[contenteditable]") || d(a, "textarea,[contenteditable]") || d(a, "button,[contenteditable]");
    }
    function p(b) {
        var c = a(b);
        return n(c.width) + n(c.paddingLeft) + n(c.paddingRight) + n(c.borderLeftWidth) + n(c.borderRightWidth);
    }
    function q(a) {
        var b = Math.ceil,
            c = a.element,
            d = v(c.scrollTop),
            g = c.getBoundingClientRect();
        (a.containerWidth = b(g.width)),
            (a.containerHeight = b(g.height)),
            (a.contentWidth = c.scrollWidth),
            (a.contentHeight = c.scrollHeight),
            c.contains(a.scrollbarXRail) ||
                (f(c, z.element.rail("x")).forEach(function (a) {
                    return e(a);
                }),
                c.appendChild(a.scrollbarXRail)),
            c.contains(a.scrollbarYRail) ||
                (f(c, z.element.rail("y")).forEach(function (a) {
                    return e(a);
                }),
                c.appendChild(a.scrollbarYRail)),
            !a.settings.suppressScrollX && a.containerWidth + a.settings.scrollXMarginOffset < a.contentWidth
                ? ((a.scrollbarXActive = !0),
                  (a.railXWidth = a.containerWidth - a.railXMarginWidth),
                  (a.railXRatio = a.containerWidth / a.railXWidth),
                  (a.scrollbarXWidth = r(a, n((a.railXWidth * a.containerWidth) / a.contentWidth))),
                  (a.scrollbarXLeft = n(((a.negativeScrollAdjustment + c.scrollLeft) * (a.railXWidth - a.scrollbarXWidth)) / (a.contentWidth - a.containerWidth))))
                : (a.scrollbarXActive = !1),
            !a.settings.suppressScrollY && a.containerHeight + a.settings.scrollYMarginOffset < a.contentHeight
                ? ((a.scrollbarYActive = !0),
                  (a.railYHeight = a.containerHeight - a.railYMarginHeight),
                  (a.railYRatio = a.containerHeight / a.railYHeight),
                  (a.scrollbarYHeight = r(a, n((a.railYHeight * a.containerHeight) / a.contentHeight))),
                  (a.scrollbarYTop = n((d * (a.railYHeight - a.scrollbarYHeight)) / (a.contentHeight - a.containerHeight))))
                : (a.scrollbarYActive = !1),
            a.scrollbarXLeft >= a.railXWidth - a.scrollbarXWidth && (a.scrollbarXLeft = a.railXWidth - a.scrollbarXWidth),
            a.scrollbarYTop >= a.railYHeight - a.scrollbarYHeight && (a.scrollbarYTop = a.railYHeight - a.scrollbarYHeight),
            s(c, a),
            a.scrollbarXActive ? c.classList.add(z.state.active("x")) : (c.classList.remove(z.state.active("x")), (a.scrollbarXWidth = 0), (a.scrollbarXLeft = 0), (c.scrollLeft = !0 === a.isRtl ? a.contentWidth : 0)),
            a.scrollbarYActive ? c.classList.add(z.state.active("y")) : (c.classList.remove(z.state.active("y")), (a.scrollbarYHeight = 0), (a.scrollbarYTop = 0), (c.scrollTop = 0));
    }
    function r(a, b) {
        var c = Math.min,
            d = Math.max;
        return a.settings.minScrollbarLength && (b = d(b, a.settings.minScrollbarLength)), a.settings.maxScrollbarLength && (b = c(b, a.settings.maxScrollbarLength)), b;
    }
    function s(a, c) {
        var d = { width: c.railXWidth },
            e = v(a.scrollTop);
        (d.left = c.isRtl ? c.negativeScrollAdjustment + a.scrollLeft + c.containerWidth - c.contentWidth : a.scrollLeft),
            c.isScrollbarXUsingBottom ? (d.bottom = c.scrollbarXBottom - e) : (d.top = c.scrollbarXTop + e),
            b(c.scrollbarXRail, d);
        var f = { top: e, height: c.railYHeight };
        c.isScrollbarYUsingRight
            ? c.isRtl
                ? (f.right = c.contentWidth - (c.negativeScrollAdjustment + a.scrollLeft) - c.scrollbarYRight - c.scrollbarYOuterWidth - 9)
                : (f.right = c.scrollbarYRight - a.scrollLeft)
            : c.isRtl
            ? (f.left = c.negativeScrollAdjustment + a.scrollLeft + 2 * c.containerWidth - c.contentWidth - c.scrollbarYLeft - c.scrollbarYOuterWidth)
            : (f.left = c.scrollbarYLeft + a.scrollLeft),
            b(c.scrollbarYRail, f),
            b(c.scrollbarX, { left: c.scrollbarXLeft, width: c.scrollbarXWidth - c.railBorderXWidth }),
            b(c.scrollbarY, { top: c.scrollbarYTop, height: c.scrollbarYHeight - c.railBorderYWidth });
    }
    function t(a, b) {
        function c(b) {
            b.touches && b.touches[0] && (b[k] = b.touches[0].pageY), (s[o] = t + v * (b[k] - u)), g(a, p), q(a), b.stopPropagation(), b.preventDefault();
        }
        function d() {
            h(a, p), a[r].classList.remove(z.state.clicking), a.event.unbind(a.ownerDocument, "mousemove", c);
        }
        function f(b, e) {
            (t = s[o]),
                e && b.touches && (b[k] = b.touches[0].pageY),
                (u = b[k]),
                (v = (a[j] - a[i]) / (a[l] - a[n])),
                e ? a.event.bind(a.ownerDocument, "touchmove", c) : (a.event.bind(a.ownerDocument, "mousemove", c), a.event.once(a.ownerDocument, "mouseup", d), b.preventDefault()),
                a[r].classList.add(z.state.clicking),
                b.stopPropagation();
        }
        var i = b[0],
            j = b[1],
            k = b[2],
            l = b[3],
            m = b[4],
            n = b[5],
            o = b[6],
            p = b[7],
            r = b[8],
            s = a.element,
            t = null,
            u = null,
            v = null;
        a.event.bind(a[m], "mousedown", function (a) {
            f(a);
        }),
            a.event.bind(a[m], "touchstart", function (a) {
                f(a, !0);
            });
    }
    var w = "undefined" != typeof Element && (Element.prototype.matches || Element.prototype.webkitMatchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector),
        z = {
            main: "ps",
            rtl: "ps__rtl",
            element: {
                thumb: function (a) {
                    return "ps__thumb-" + a;
                },
                rail: function (a) {
                    return "ps__rail-" + a;
                },
                consuming: "ps__child--consume",
            },
            state: {
                focus: "ps--focus",
                clicking: "ps--clicking",
                active: function (a) {
                    return "ps--active-" + a;
                },
                scrolling: function (a) {
                    return "ps--scrolling-" + a;
                },
            },
        },
        A = { x: null, y: null },
        B = function (a) {
            (this.element = a), (this.handlers = {});
        },
        C = { isEmpty: { configurable: !0 } };
    (B.prototype.bind = function (a, b) {
        "undefined" == typeof this.handlers[a] && (this.handlers[a] = []), this.handlers[a].push(b), this.element.addEventListener(a, b, !1);
    }),
        (B.prototype.unbind = function (a, b) {
            var c = this;
            this.handlers[a] = this.handlers[a].filter(function (d) {
                return !!(b && d !== b) || (c.element.removeEventListener(a, d, !1), !1);
            });
        }),
        (B.prototype.unbindAll = function () {
            for (var a in this.handlers) this.unbind(a);
        }),
        (C.isEmpty.get = function () {
            var a = this;
            return Object.keys(this.handlers).every(function (b) {
                return 0 === a.handlers[b].length;
            });
        }),
        Object.defineProperties(B.prototype, C);
    var D = function () {
        this.eventElements = [];
    };
    (D.prototype.eventElement = function (a) {
        var b = this.eventElements.filter(function (b) {
            return b.element === a;
        })[0];
        return b || ((b = new B(a)), this.eventElements.push(b)), b;
    }),
        (D.prototype.bind = function (a, b, c) {
            this.eventElement(a).bind(b, c);
        }),
        (D.prototype.unbind = function (a, b, c) {
            var d = this.eventElement(a);
            d.unbind(b, c), d.isEmpty && this.eventElements.splice(this.eventElements.indexOf(d), 1);
        }),
        (D.prototype.unbindAll = function () {
            this.eventElements.forEach(function (a) {
                return a.unbindAll();
            }),
                (this.eventElements = []);
        }),
        (D.prototype.once = function (a, b, c) {
            var d = this.eventElement(a),
                e = function (a) {
                    d.unbind(b, e), c(a);
                };
            d.bind(b, e);
        });
    var E = {
            isWebKit: "undefined" != typeof document && "WebkitAppearance" in document.documentElement.style,
            supportsTouch: "undefined" != typeof window && ("ontouchstart" in window || ("maxTouchPoints" in window.navigator && 0 < window.navigator.maxTouchPoints) || (window.DocumentTouch && document instanceof window.DocumentTouch)),
            supportsIePointer: "undefined" != typeof navigator && navigator.msMaxTouchPoints,
            isChrome: "undefined" != typeof navigator && /Chrome/i.test(navigator && navigator.userAgent),
        },
        F = function () {
            return {
                handlers: ["click-rail", "drag-thumb", "keyboard", "wheel", "touch"],
                maxScrollbarLength: null,
                minScrollbarLength: null,
                scrollingThreshold: 1e3,
                scrollXMarginOffset: 0,
                scrollYMarginOffset: 0,
                suppressScrollX: !1,
                suppressScrollY: !1,
                swipeEasing: !0,
                useBothWheelAxes: !1,
                wheelPropagation: !0,
                wheelSpeed: 1,
            };
        },
        G = {
            "click-rail": function (a) {
                a.element;
                a.event.bind(a.scrollbarY, "mousedown", function (a) {
                    return a.stopPropagation();
                }),
                    a.event.bind(a.scrollbarYRail, "mousedown", function (b) {
                        var c = b.pageY - window.pageYOffset - a.scrollbarYRail.getBoundingClientRect().top,
                            d = c > a.scrollbarYTop ? 1 : -1;
                        (a.element.scrollTop += d * a.containerHeight), q(a), b.stopPropagation();
                    }),
                    a.event.bind(a.scrollbarX, "mousedown", function (a) {
                        return a.stopPropagation();
                    }),
                    a.event.bind(a.scrollbarXRail, "mousedown", function (b) {
                        var c = b.pageX - window.pageXOffset - a.scrollbarXRail.getBoundingClientRect().left,
                            d = c > a.scrollbarXLeft ? 1 : -1;
                        (a.element.scrollLeft += d * a.containerWidth), q(a), b.stopPropagation();
                    });
            },
            "drag-thumb": function (a) {
                t(a, ["containerWidth", "contentWidth", "pageX", "railXWidth", "scrollbarX", "scrollbarXWidth", "scrollLeft", "x", "scrollbarXRail"]),
                    t(a, ["containerHeight", "contentHeight", "pageY", "railYHeight", "scrollbarY", "scrollbarYHeight", "scrollTop", "y", "scrollbarYRail"]);
            },
            keyboard: function (a) {
                function b(b, d) {
                    var e = v(c.scrollTop);
                    if (0 === b) {
                        if (!a.scrollbarYActive) return !1;
                        if ((0 === e && 0 < d) || (e >= a.contentHeight - a.containerHeight && 0 > d)) return !a.settings.wheelPropagation;
                    }
                    var f = c.scrollLeft;
                    if (0 === d) {
                        if (!a.scrollbarXActive) return !1;
                        if ((0 === f && 0 > b) || (f >= a.contentWidth - a.containerWidth && 0 < b)) return !a.settings.wheelPropagation;
                    }
                    return !0;
                }
                var c = a.element,
                    f = function () {
                        return d(c, ":hover");
                    },
                    g = function () {
                        return d(a.scrollbarX, ":focus") || d(a.scrollbarY, ":focus");
                    };
                a.event.bind(a.ownerDocument, "keydown", function (d) {
                    if (!((d.isDefaultPrevented && d.isDefaultPrevented()) || d.defaultPrevented) && (f() || g())) {
                        var e = document.activeElement ? document.activeElement : a.ownerDocument.activeElement;
                        if (e) {
                            if ("IFRAME" === e.tagName) e = e.contentDocument.activeElement;
                            // go deeper if element is a webcomponent
                            else for (; e.shadowRoot; ) e = e.shadowRoot.activeElement;
                            if (o(e)) return;
                        }
                        var h = 0,
                            i = 0;
                        switch (d.which) {
                            case 37:
                                h = d.metaKey ? -a.contentWidth : d.altKey ? -a.containerWidth : -30;
                                break;
                            case 38:
                                i = d.metaKey ? a.contentHeight : d.altKey ? a.containerHeight : 30;
                                break;
                            case 39:
                                h = d.metaKey ? a.contentWidth : d.altKey ? a.containerWidth : 30;
                                break;
                            case 40:
                                i = d.metaKey ? -a.contentHeight : d.altKey ? -a.containerHeight : -30;
                                break;
                            case 32:
                                i = d.shiftKey ? a.containerHeight : -a.containerHeight;
                                break;
                            case 33:
                                i = a.containerHeight;
                                break;
                            case 34:
                                i = -a.containerHeight;
                                break;
                            case 36:
                                i = a.contentHeight;
                                break;
                            case 35:
                                i = -a.contentHeight;
                                break;
                            default:
                                return;
                        }
                        (a.settings.suppressScrollX && 0 !== h) || (a.settings.suppressScrollY && 0 !== i) || ((c.scrollTop -= i), (c.scrollLeft += h), q(a), b(h, i) && d.preventDefault());
                    }
                });
            },
            wheel: function (b) {
                function c(a, c) {
                    var d,
                        e = v(h.scrollTop),
                        f = 0 === h.scrollTop,
                        g = e + h.offsetHeight === h.scrollHeight,
                        i = 0 === h.scrollLeft,
                        j = h.scrollLeft + h.offsetWidth === h.scrollWidth;
                    return (d = u(c) > u(a) ? f || g : i || j), !d || !b.settings.wheelPropagation;
                }
                function d(a) {
                    var b = a.deltaX,
                        c = -1 * a.deltaY;
                    return (
                        ("undefined" == typeof b || "undefined" == typeof c) && ((b = (-1 * a.wheelDeltaX) / 6), (c = a.wheelDeltaY / 6)),
                        a.deltaMode && 1 === a.deltaMode && ((b *= 10), (c *= 10)),
                        b !== b && c !== c /* NaN checks */ && ((b = 0), (c = a.wheelDelta)),
                        a.shiftKey ? [-c, -b] : [b, c]
                    );
                }
                function f(b, c, d) {
                    // FIXME: this is a workaround for <select> issue in FF and IE #571
                    if (!E.isWebKit && h.querySelector("select:focus")) return !0;
                    if (!h.contains(b)) return !1;
                    for (var e = b; e && e !== h; ) {
                        if (e.classList.contains(z.element.consuming)) return !0;
                        var f = a(e); // if deltaY && vertical scrollable
                        if (d && f.overflowY.match(/(scroll|auto)/)) {
                            var g = e.scrollHeight - e.clientHeight;
                            if (0 < g && ((0 < e.scrollTop && 0 > d) || (e.scrollTop < g && 0 < d))) return !0;
                        } // if deltaX && horizontal scrollable
                        if (c && f.overflowX.match(/(scroll|auto)/)) {
                            var i = e.scrollWidth - e.clientWidth;
                            if (0 < i && ((0 < e.scrollLeft && 0 > c) || (e.scrollLeft < i && 0 < c))) return !0;
                        }
                        e = e.parentNode;
                    }
                    return !1;
                }
                function g(a) {
                    var e = d(a),
                        g = e[0],
                        i = e[1];
                    if (!f(a.target, g, i)) {
                        var j = !1;
                        b.settings.useBothWheelAxes
                            ? b.scrollbarYActive && !b.scrollbarXActive
                                ? (i ? (h.scrollTop -= i * b.settings.wheelSpeed) : (h.scrollTop += g * b.settings.wheelSpeed), (j = !0))
                                : b.scrollbarXActive && !b.scrollbarYActive && (g ? (h.scrollLeft += g * b.settings.wheelSpeed) : (h.scrollLeft -= i * b.settings.wheelSpeed), (j = !0))
                            : ((h.scrollTop -= i * b.settings.wheelSpeed), (h.scrollLeft += g * b.settings.wheelSpeed)),
                            q(b),
                            (j = j || c(g, i)),
                            j && !a.ctrlKey && (a.stopPropagation(), a.preventDefault());
                    }
                }
                var h = b.element;
                "undefined" == typeof window.onwheel ? "undefined" != typeof window.onmousewheel && b.event.bind(h, "mousewheel", g) : b.event.bind(h, "wheel", g);
            },
            touch: function (b) {
                function c(a, c) {
                    var d = v(l.scrollTop),
                        e = l.scrollLeft,
                        f = u(a),
                        g = u(c);
                    if (g > f) {
                        // user is perhaps trying to swipe up/down the page
                        if ((0 > c && d === b.contentHeight - b.containerHeight) || (0 < c && 0 === d))
                            // set prevent for mobile Chrome refresh
                            return 0 === window.scrollY && 0 < c && E.isChrome;
                    } else if (f > g && ((0 > a && e === b.contentWidth - b.containerWidth) || (0 < a && 0 === e)))
                        // user is perhaps trying to swipe left/right across the page
                        return !0;
                    return !0;
                }
                function d(a, c) {
                    (l.scrollTop -= c), (l.scrollLeft -= a), q(b);
                }
                function f(a) {
                    return a.targetTouches ? a.targetTouches[0] : a;
                }
                function g(a) {
                    return (
                        !(a.pointerType && "pen" === a.pointerType && 0 === a.buttons) && (!!(a.targetTouches && 1 === a.targetTouches.length) || !!(a.pointerType && "mouse" !== a.pointerType && a.pointerType !== a.MSPOINTER_TYPE_MOUSE))
                    );
                }
                function h(a) {
                    if (g(a)) {
                        var b = f(a);
                        (m.pageX = b.pageX), (m.pageY = b.pageY), (n = new Date().getTime()), null !== p && clearInterval(p);
                    }
                }
                function i(b, c, d) {
                    if (!l.contains(b)) return !1;
                    for (var e = b; e && e !== l; ) {
                        if (e.classList.contains(z.element.consuming)) return !0;
                        var f = a(e); // if deltaY && vertical scrollable
                        if (d && f.overflowY.match(/(scroll|auto)/)) {
                            var g = e.scrollHeight - e.clientHeight;
                            if (0 < g && ((0 < e.scrollTop && 0 > d) || (e.scrollTop < g && 0 < d))) return !0;
                        } // if deltaX && horizontal scrollable
                        if (c && f.overflowX.match(/(scroll|auto)/)) {
                            var h = e.scrollWidth - e.clientWidth;
                            if (0 < h && ((0 < e.scrollLeft && 0 > c) || (e.scrollLeft < h && 0 < c))) return !0;
                        }
                        e = e.parentNode;
                    }
                    return !1;
                }
                function j(a) {
                    if (g(a)) {
                        var b = f(a),
                            e = { pageX: b.pageX, pageY: b.pageY },
                            h = e.pageX - m.pageX,
                            j = e.pageY - m.pageY;
                        if (i(a.target, h, j)) return;
                        d(h, j), (m = e);
                        var k = new Date().getTime(),
                            l = k - n;
                        0 < l && ((o.x = h / l), (o.y = j / l), (n = k)), c(h, j) && a.preventDefault();
                    }
                }
                function k() {
                    b.settings.swipeEasing &&
                        (clearInterval(p),
                        (p = setInterval(function () {
                            return b.isInitialized ? void clearInterval(p) : o.x || o.y ? (0.01 > u(o.x) && 0.01 > u(o.y) ? void clearInterval(p) : void (d(30 * o.x, 30 * o.y), (o.x *= 0.8), (o.y *= 0.8))) : void clearInterval(p);
                        }, 10)));
                }
                if (E.supportsTouch || E.supportsIePointer) {
                    var l = b.element,
                        m = {},
                        n = 0,
                        o = {},
                        p = null;
                    E.supportsTouch
                        ? (b.event.bind(l, "touchstart", h), b.event.bind(l, "touchmove", j), b.event.bind(l, "touchend", k))
                        : E.supportsIePointer &&
                          (window.PointerEvent
                              ? (b.event.bind(l, "pointerdown", h), b.event.bind(l, "pointermove", j), b.event.bind(l, "pointerup", k))
                              : window.MSPointerEvent && (b.event.bind(l, "MSPointerDown", h), b.event.bind(l, "MSPointerMove", j), b.event.bind(l, "MSPointerUp", k)));
                }
            },
        },
        H = function (d, e) {
            var f = this;
            if ((void 0 === e && (e = {}), "string" == typeof d && (d = document.querySelector(d)), !d || !d.nodeName)) throw new Error("no element is specified to initialize PerfectScrollbar");
            for (var g in ((this.element = d), d.classList.add(z.main), (this.settings = F()), e)) this.settings[g] = e[g];
            (this.containerWidth = null), (this.containerHeight = null), (this.contentWidth = null), (this.contentHeight = null);
            var h = function () {
                    return d.classList.add(z.state.focus);
                },
                i = function () {
                    return d.classList.remove(z.state.focus);
                };
            (this.isRtl = "rtl" === a(d).direction),
                !0 === this.isRtl && d.classList.add(z.rtl),
                (this.isNegativeScroll = (function () {
                    var a = d.scrollLeft,
                        b = null;
                    return (d.scrollLeft = -1), (b = 0 > d.scrollLeft), (d.scrollLeft = a), b;
                })()),
                (this.negativeScrollAdjustment = this.isNegativeScroll ? d.scrollWidth - d.clientWidth : 0),
                (this.event = new D()),
                (this.ownerDocument = d.ownerDocument || document),
                (this.scrollbarXRail = c(z.element.rail("x"))),
                d.appendChild(this.scrollbarXRail),
                (this.scrollbarX = c(z.element.thumb("x"))),
                this.scrollbarXRail.appendChild(this.scrollbarX),
                this.scrollbarX.setAttribute("tabindex", 0),
                this.event.bind(this.scrollbarX, "focus", h),
                this.event.bind(this.scrollbarX, "blur", i),
                (this.scrollbarXActive = null),
                (this.scrollbarXWidth = null),
                (this.scrollbarXLeft = null);
            var j = a(this.scrollbarXRail);
            (this.scrollbarXBottom = parseInt(j.bottom, 10)),
                isNaN(this.scrollbarXBottom) ? ((this.isScrollbarXUsingBottom = !1), (this.scrollbarXTop = n(j.top))) : (this.isScrollbarXUsingBottom = !0),
                (this.railBorderXWidth = n(j.borderLeftWidth) + n(j.borderRightWidth)),
                b(this.scrollbarXRail, { display: "block" }),
                (this.railXMarginWidth = n(j.marginLeft) + n(j.marginRight)),
                b(this.scrollbarXRail, { display: "" }),
                (this.railXWidth = null),
                (this.railXRatio = null),
                (this.scrollbarYRail = c(z.element.rail("y"))),
                d.appendChild(this.scrollbarYRail),
                (this.scrollbarY = c(z.element.thumb("y"))),
                this.scrollbarYRail.appendChild(this.scrollbarY),
                this.scrollbarY.setAttribute("tabindex", 0),
                this.event.bind(this.scrollbarY, "focus", h),
                this.event.bind(this.scrollbarY, "blur", i),
                (this.scrollbarYActive = null),
                (this.scrollbarYHeight = null),
                (this.scrollbarYTop = null);
            var k = a(this.scrollbarYRail);
            (this.scrollbarYRight = parseInt(k.right, 10)),
                isNaN(this.scrollbarYRight) ? ((this.isScrollbarYUsingRight = !1), (this.scrollbarYLeft = n(k.left))) : (this.isScrollbarYUsingRight = !0),
                (this.scrollbarYOuterWidth = this.isRtl ? p(this.scrollbarY) : null),
                (this.railBorderYWidth = n(k.borderTopWidth) + n(k.borderBottomWidth)),
                b(this.scrollbarYRail, { display: "block" }),
                (this.railYMarginHeight = n(k.marginTop) + n(k.marginBottom)),
                b(this.scrollbarYRail, { display: "" }),
                (this.railYHeight = null),
                (this.railYRatio = null),
                (this.reach = {
                    x: 0 >= d.scrollLeft ? "start" : d.scrollLeft >= this.contentWidth - this.containerWidth ? "end" : null,
                    y: 0 >= d.scrollTop ? "start" : d.scrollTop >= this.contentHeight - this.containerHeight ? "end" : null,
                }),
                (this.isAlive = !0),
                this.settings.handlers.forEach(function (a) {
                    return G[a](f);
                }),
                (this.lastScrollTop = v(d.scrollTop)),
                (this.lastScrollLeft = d.scrollLeft),
                this.event.bind(this.element, "scroll", function (a) {
                    return f.onScroll(a);
                }),
                q(this);
        };
    return (
        (H.prototype.update = function () {
            this.isAlive && // Recalcuate negative scrollLeft adjustment
                // Recalculate rail margins
                // Hide scrollbars not to affect scrollWidth and scrollHeight
                ((this.negativeScrollAdjustment = this.isNegativeScroll ? this.element.scrollWidth - this.element.clientWidth : 0),
                b(this.scrollbarXRail, { display: "block" }),
                b(this.scrollbarYRail, { display: "block" }),
                (this.railXMarginWidth = n(a(this.scrollbarXRail).marginLeft) + n(a(this.scrollbarXRail).marginRight)),
                (this.railYMarginHeight = n(a(this.scrollbarYRail).marginTop) + n(a(this.scrollbarYRail).marginBottom)),
                b(this.scrollbarXRail, { display: "none" }),
                b(this.scrollbarYRail, { display: "none" }),
                q(this),
                l(this, "top", 0, !1, !0),
                l(this, "left", 0, !1, !0),
                b(this.scrollbarXRail, { display: "" }),
                b(this.scrollbarYRail, { display: "" }));
        }),
        (H.prototype.onScroll = function () {
            this.isAlive &&
                (q(this),
                l(this, "top", this.element.scrollTop - this.lastScrollTop),
                l(this, "left", this.element.scrollLeft - this.lastScrollLeft),
                (this.lastScrollTop = v(this.element.scrollTop)),
                (this.lastScrollLeft = this.element.scrollLeft));
        }),
        (H.prototype.destroy = function () {
            this.isAlive && // unset elements
                (this.event.unbindAll(),
                e(this.scrollbarX),
                e(this.scrollbarY),
                e(this.scrollbarXRail),
                e(this.scrollbarYRail),
                this.removePsClasses(),
                (this.element = null),
                (this.scrollbarX = null),
                (this.scrollbarY = null),
                (this.scrollbarXRail = null),
                (this.scrollbarYRail = null),
                (this.isAlive = !1));
        }),
        (H.prototype.removePsClasses = function () {
            this.element.className = this.element.className
                .split(" ")
                .filter(function (a) {
                    return !a.match(/^ps([-_].+|)$/);
                })
                .join(" ");
        }),
        H
    );
});
