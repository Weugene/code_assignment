var POST_ID_CURRENT = null;
(() => {
  var e = {
      299: function (e) {
        e.exports = (function () {
          "use strict";
          (function () {
            for (
              var e = 0, t = ["ms", "moz", "webkit", "o"], n = 0;
              n < t.length && !window.requestAnimationFrame;
              ++n
            )
              (window.requestAnimationFrame =
                window[t[n] + "RequestAnimationFrame"]),
                (window.cancelAnimationFrame =
                  window[t[n] + "CancelAnimationFrame"] ||
                  window[t[n] + "CancelRequestAnimationFrame"]);
            window.requestAnimationFrame ||
              (window.requestAnimationFrame = function (t, n) {
                var s = new Date().getTime(),
                  a = Math.max(0, 16 - (s - e)),
                  i = window.setTimeout(function () {
                    t(s + a);
                  }, a);
                return (e = s + a), i;
              }),
              window.cancelAnimationFrame ||
                (window.cancelAnimationFrame = function (e) {
                  clearTimeout(e);
                });
          })(),
            (function () {
              if ("function" == typeof window.CustomEvent) return !1;
              function e(e, t) {
                t = t || { bubbles: !1, cancelable: !1, detail: void 0 };
                var n = document.createEvent("CustomEvent");
                return (
                  n.initCustomEvent(e, t.bubbles, t.cancelable, t.detail), n
                );
              }
              (e.prototype = window.Event.prototype), (window.CustomEvent = e);
            })(),
            (function (e) {
              try {
                return new CustomEvent("test"), !1;
              } catch (e) {}
              function t(t, n) {
                n = n || { bubbles: !1, cancelable: !1 };
                var s = document.createEvent("MouseEvent");
                return (
                  s.initMouseEvent(
                    t,
                    n.bubbles,
                    n.cancelable,
                    e,
                    0,
                    0,
                    0,
                    0,
                    0,
                    !1,
                    !1,
                    !1,
                    !1,
                    0,
                    null
                  ),
                  s
                );
              }
              (t.prototype = Event.prototype), (e.MouseEvent = t);
            })(window);
          var e = function (e, t) {
              if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function");
            },
            t = (function () {
              function e(e, t) {
                for (var n = 0; n < t.length; n++) {
                  var s = t[n];
                  (s.enumerable = s.enumerable || !1),
                    (s.configurable = !0),
                    "value" in s && (s.writable = !0),
                    Object.defineProperty(e, s.key, s);
                }
              }
              return function (t, n, s) {
                return n && e(t.prototype, n), s && e(t, s), t;
              };
            })(),
            n = function e(t, n, s) {
              null === t && (t = Function.prototype);
              var a = Object.getOwnPropertyDescriptor(t, n);
              if (void 0 === a) {
                var i = Object.getPrototypeOf(t);
                return null === i ? void 0 : e(i, n, s);
              }
              if ("value" in a) return a.value;
              var r = a.get;
              return void 0 !== r ? r.call(s) : void 0;
            },
            s = function (e, t) {
              if (!e)
                throw new ReferenceError(
                  "this hasn't been initialised - super() hasn't been called"
                );
              return !t || ("object" != typeof t && "function" != typeof t)
                ? e
                : t;
            },
            a = function (e, t) {
              if (Array.isArray(e)) return e;
              if (Symbol.iterator in Object(e))
                return (function (e, t) {
                  var n = [],
                    s = !0,
                    a = !1,
                    i = void 0;
                  try {
                    for (
                      var r, o = e[Symbol.iterator]();
                      !(s = (r = o.next()).done) &&
                      (n.push(r.value), !t || n.length !== t);
                      s = !0
                    );
                  } catch (e) {
                    (a = !0), (i = e);
                  } finally {
                    try {
                      !s && o.return && o.return();
                    } finally {
                      if (a) throw i;
                    }
                  }
                  return n;
                })(e, t);
              throw new TypeError(
                "Invalid attempt to destructure non-iterable instance"
              );
            },
            i = function t(n, s, a, i) {
              e(this, t);
              var r = this;
              function o(e) {
                e.stopPropagation(),
                  document.removeEventListener("mouseup", o),
                  document.removeEventListener("mousemove", l),
                  r.eventBus.dispatchEvent(
                    new CustomEvent("handleend", { detail: { handle: r } })
                  );
              }
              function l(e) {
                e.stopPropagation(),
                  r.eventBus.dispatchEvent(
                    new CustomEvent("handlemove", {
                      detail: { mouseX: e.clientX, mouseY: e.clientY },
                    })
                  );
              }
              (this.position = n),
                (this.constraints = s),
                (this.cursor = a),
                (this.eventBus = i),
                (this.el = document.createElement("div")),
                (this.el.className = "croppr-handle"),
                (this.el.style.cursor = a),
                this.el.addEventListener("mousedown", function (e) {
                  e.stopPropagation(),
                    document.addEventListener("mouseup", o),
                    document.addEventListener("mousemove", l),
                    r.eventBus.dispatchEvent(
                      new CustomEvent("handlestart", { detail: { handle: r } })
                    );
                });
            },
            r = (function () {
              function n(t, s, a, i) {
                e(this, n),
                  (this.x1 = t),
                  (this.y1 = s),
                  (this.x2 = a),
                  (this.y2 = i);
              }
              return (
                t(n, [
                  {
                    key: "set",
                    value: function () {
                      var e =
                          arguments.length > 0 && void 0 !== arguments[0]
                            ? arguments[0]
                            : null,
                        t =
                          arguments.length > 1 && void 0 !== arguments[1]
                            ? arguments[1]
                            : null,
                        n =
                          arguments.length > 2 && void 0 !== arguments[2]
                            ? arguments[2]
                            : null,
                        s =
                          arguments.length > 3 && void 0 !== arguments[3]
                            ? arguments[3]
                            : null;
                      return (
                        (this.x1 = null == e ? this.x1 : e),
                        (this.y1 = null == t ? this.y1 : t),
                        (this.x2 = null == n ? this.x2 : n),
                        (this.y2 = null == s ? this.y2 : s),
                        this
                      );
                    },
                  },
                  {
                    key: "width",
                    value: function () {
                      return Math.abs(this.x2 - this.x1);
                    },
                  },
                  {
                    key: "height",
                    value: function () {
                      return Math.abs(this.y2 - this.y1);
                    },
                  },
                  {
                    key: "resize",
                    value: function (e, t) {
                      var n =
                          arguments.length > 2 && void 0 !== arguments[2]
                            ? arguments[2]
                            : [0, 0],
                        s = this.x1 + this.width() * n[0],
                        a = this.y1 + this.height() * n[1];
                      return (
                        (this.x1 = s - e * n[0]),
                        (this.y1 = a - t * n[1]),
                        (this.x2 = this.x1 + e),
                        (this.y2 = this.y1 + t),
                        this
                      );
                    },
                  },
                  {
                    key: "scale",
                    value: function (e) {
                      var t =
                          arguments.length > 1 && void 0 !== arguments[1]
                            ? arguments[1]
                            : [0, 0],
                        n = this.width() * e,
                        s = this.height() * e;
                      return this.resize(n, s, t), this;
                    },
                  },
                  {
                    key: "move",
                    value: function () {
                      var e =
                          arguments.length > 0 && void 0 !== arguments[0]
                            ? arguments[0]
                            : null,
                        t =
                          arguments.length > 1 && void 0 !== arguments[1]
                            ? arguments[1]
                            : null,
                        n = this.width(),
                        s = this.height();
                      return (
                        (e = null === e ? this.x1 : e),
                        (t = null === t ? this.y1 : t),
                        (this.x1 = e),
                        (this.y1 = t),
                        (this.x2 = e + n),
                        (this.y2 = t + s),
                        this
                      );
                    },
                  },
                  {
                    key: "getRelativePoint",
                    value: function () {
                      var e =
                        arguments.length > 0 && void 0 !== arguments[0]
                          ? arguments[0]
                          : [0, 0];
                      return [this.width() * e[0], this.height() * e[1]];
                    },
                  },
                  {
                    key: "getAbsolutePoint",
                    value: function () {
                      var e =
                        arguments.length > 0 && void 0 !== arguments[0]
                          ? arguments[0]
                          : [0, 0];
                      return [
                        this.x1 + this.width() * e[0],
                        this.y1 + this.height() * e[1],
                      ];
                    },
                  },
                  {
                    key: "constrainToRatio",
                    value: function (e) {
                      var t =
                          arguments.length > 1 && void 0 !== arguments[1]
                            ? arguments[1]
                            : [0, 0],
                        n =
                          arguments.length > 2 && void 0 !== arguments[2]
                            ? arguments[2]
                            : "height";
                      if (null !== e) {
                        switch ((this.width(), this.height(), n)) {
                          case "height":
                          default:
                            this.resize(this.width(), this.width() * e, t);
                            break;
                          case "width":
                            this.resize(
                              (1 * this.height()) / e,
                              this.height(),
                              t
                            );
                        }
                        return this;
                      }
                    },
                  },
                  {
                    key: "constrainToBoundary",
                    value: function (e, t) {
                      var n =
                          arguments.length > 2 && void 0 !== arguments[2]
                            ? arguments[2]
                            : [0, 0],
                        s = this.getAbsolutePoint(n),
                        i = a(s, 2),
                        r = i[0],
                        o = i[1],
                        l = r,
                        u = o,
                        c = e - r,
                        d = t - o,
                        m = -2 * n[0] + 1,
                        p = -2 * n[1] + 1,
                        _ = null,
                        h = null;
                      switch (m) {
                        case -1:
                          _ = l;
                          break;
                        case 0:
                          _ = 2 * Math.min(l, c);
                          break;
                        case 1:
                          _ = c;
                      }
                      switch (p) {
                        case -1:
                          h = u;
                          break;
                        case 0:
                          h = 2 * Math.min(u, d);
                          break;
                        case 1:
                          h = d;
                      }
                      if (this.width() > _) {
                        var w = _ / this.width();
                        this.scale(w, n);
                      }
                      if (this.height() > h) {
                        var g = h / this.height();
                        this.scale(g, n);
                      }
                      return this;
                    },
                  },
                  {
                    key: "constrainToSize",
                    value: function () {
                      var e =
                          arguments.length > 0 && void 0 !== arguments[0]
                            ? arguments[0]
                            : null,
                        t =
                          arguments.length > 1 && void 0 !== arguments[1]
                            ? arguments[1]
                            : null,
                        n =
                          arguments.length > 2 && void 0 !== arguments[2]
                            ? arguments[2]
                            : null,
                        s =
                          arguments.length > 3 && void 0 !== arguments[3]
                            ? arguments[3]
                            : null,
                        a =
                          arguments.length > 4 && void 0 !== arguments[4]
                            ? arguments[4]
                            : [0, 0],
                        i =
                          arguments.length > 5 && void 0 !== arguments[5]
                            ? arguments[5]
                            : null;
                      if (
                        (i &&
                          (i > 1
                            ? ((e = (1 * t) / i), (s *= i))
                            : i < 1 && ((t = e * i), (n = (1 * s) / i))),
                        e && this.width() > e)
                      ) {
                        var r = e,
                          o = null === i ? this.height() : t;
                        this.resize(r, o, a);
                      }
                      if (t && this.height() > t) {
                        var l = null === i ? this.width() : e,
                          u = t;
                        this.resize(l, u, a);
                      }
                      if (n && this.width() < n) {
                        var c = n,
                          d = null === i ? this.height() : s;
                        this.resize(c, d, a);
                      }
                      if (s && this.height() < s) {
                        var m = null === i ? this.width() : n,
                          p = s;
                        this.resize(m, p, a);
                      }
                      return this;
                    },
                  },
                ]),
                n
              );
            })();
          function o(e) {
            e.preventDefault();
            var t = e.changedTouches[0];
            t.target.dispatchEvent(
              new MouseEvent(
                {
                  touchstart: "mousedown",
                  touchmove: "mousemove",
                  touchend: "mouseup",
                }[e.type],
                {
                  bubbles: !0,
                  cancelable: !0,
                  view: window,
                  clientX: t.clientX,
                  clientY: t.clientY,
                  screenX: t.screenX,
                  screenY: t.screenY,
                }
              )
            );
          }
          var l = [
              {
                position: [0, 0],
                constraints: [1, 0, 0, 1],
                cursor: "nw-resize",
              },
              {
                position: [0.5, 0],
                constraints: [1, 0, 0, 0],
                cursor: "n-resize",
              },
              {
                position: [1, 0],
                constraints: [1, 1, 0, 0],
                cursor: "ne-resize",
              },
              {
                position: [1, 0.5],
                constraints: [0, 1, 0, 0],
                cursor: "e-resize",
              },
              {
                position: [1, 1],
                constraints: [0, 1, 1, 0],
                cursor: "se-resize",
              },
              {
                position: [0.5, 1],
                constraints: [0, 0, 1, 0],
                cursor: "s-resize",
              },
              {
                position: [0, 1],
                constraints: [0, 0, 1, 1],
                cursor: "sw-resize",
              },
              {
                position: [0, 0.5],
                constraints: [0, 0, 0, 1],
                cursor: "w-resize",
              },
            ],
            u = (function () {
              function n(t, s) {
                var a = this,
                  i =
                    arguments.length > 2 &&
                    void 0 !== arguments[2] &&
                    arguments[2];
                if (
                  (e(this, n),
                  (this.options = n.parseOptions(s || {})),
                  !t.nodeName && null == (t = document.querySelector(t)))
                )
                  throw "Unable to find element.";
                if (!t.getAttribute("src")) throw "Image src not provided.";
                (this._initialized = !1),
                  (this._restore = { parent: t.parentNode, element: t }),
                  i ||
                    (0 === t.width || 0 === t.height
                      ? (t.onload = function () {
                          a.initialize(t);
                        })
                      : this.initialize(t));
              }
              return (
                t(
                  n,
                  [
                    {
                      key: "initialize",
                      value: function (e) {
                        this.createDOM(e),
                          this.options.convertToPixels(this.cropperEl),
                          this.attachHandlerEvents(),
                          this.attachRegionEvents(),
                          this.attachOverlayEvents(),
                          (this.box = this.initializeBox(this.options)),
                          this.redraw(),
                          (this._initialized = !0),
                          null !== this.options.onInitialize &&
                            this.options.onInitialize(this);
                      },
                    },
                    {
                      key: "createDOM",
                      value: function (e) {
                        var t;
                        (this.containerEl = document.createElement("div")),
                          (this.containerEl.className = "croppr-container"),
                          (this.eventBus = this.containerEl),
                          (t = this.containerEl).addEventListener(
                            "touchstart",
                            o
                          ),
                          t.addEventListener("touchend", o),
                          t.addEventListener("touchmove", o),
                          (this.cropperEl = document.createElement("div")),
                          (this.cropperEl.className = "croppr"),
                          (this.imageEl = document.createElement("img")),
                          this.imageEl.setAttribute(
                            "src",
                            e.getAttribute("src")
                          ),
                          this.imageEl.setAttribute(
                            "alt",
                            e.getAttribute("alt")
                          ),
                          (this.imageEl.className = "croppr-image"),
                          (this.imageClippedEl = this.imageEl.cloneNode()),
                          (this.imageClippedEl.className =
                            "croppr-imageClipped"),
                          (this.regionEl = document.createElement("div")),
                          (this.regionEl.className = "croppr-region"),
                          (this.overlayEl = document.createElement("div")),
                          (this.overlayEl.className = "croppr-overlay");
                        var n = document.createElement("div");
                        (n.className = "croppr-handleContainer"),
                          (this.handles = []);
                        for (var s = 0; s < l.length; s++) {
                          var a = new i(
                            l[s].position,
                            l[s].constraints,
                            l[s].cursor,
                            this.eventBus
                          );
                          this.handles.push(a), n.appendChild(a.el);
                        }
                        this.cropperEl.appendChild(this.imageEl),
                          this.cropperEl.appendChild(this.imageClippedEl),
                          this.cropperEl.appendChild(this.regionEl),
                          this.cropperEl.appendChild(this.overlayEl),
                          this.cropperEl.appendChild(n),
                          this.containerEl.appendChild(this.cropperEl),
                          e.parentElement.replaceChild(this.containerEl, e);
                      },
                    },
                    {
                      key: "setImage",
                      value: function (e) {
                        var t = this;
                        return (
                          (this.imageEl.onload = function () {
                            (t.box = t.initializeBox(t.options)), t.redraw();
                          }),
                          (this.imageEl.src = e),
                          (this.imageClippedEl.src = e),
                          this
                        );
                      },
                    },
                    {
                      key: "destroy",
                      value: function () {
                        this._restore.parent.replaceChild(
                          this._restore.element,
                          this.containerEl
                        );
                      },
                    },
                    {
                      key: "initializeBox",
                      value: function (e) {
                        var t = e.startSize.width,
                          n = e.startSize.height,
                          s = new r(0, 0, t, n);
                        s.constrainToRatio(e.aspectRatio, [0.5, 0.5]);
                        var a = e.minSize,
                          i = e.maxSize;
                        s.constrainToSize(
                          i.width,
                          i.height,
                          a.width,
                          a.height,
                          [0.5, 0.5],
                          e.aspectRatio
                        );
                        var o = this.cropperEl.offsetWidth,
                          l = this.cropperEl.offsetHeight;
                        s.constrainToBoundary(o, l, [0.5, 0.5]);
                        var u = this.cropperEl.offsetWidth / 2 - s.width() / 2,
                          c = this.cropperEl.offsetHeight / 2 - s.height() / 2;
                        return s.move(u, c), s;
                      },
                    },
                    {
                      key: "redraw",
                      value: function () {
                        var e = this,
                          t = Math.round(this.box.width()),
                          n = Math.round(this.box.height()),
                          s = Math.round(this.box.x1),
                          a = Math.round(this.box.y1),
                          i = Math.round(this.box.x2),
                          r = Math.round(this.box.y2);
                        window.requestAnimationFrame(function () {
                          (e.regionEl.style.transform =
                            "translate(" + s + "px, " + a + "px)"),
                            (e.regionEl.style.width = t + "px"),
                            (e.regionEl.style.height = n + "px"),
                            (e.imageClippedEl.style.clip =
                              "rect(" +
                              a +
                              "px, " +
                              i +
                              "px, " +
                              r +
                              "px, " +
                              s +
                              "px)");
                          for (
                            var o = e.box.getAbsolutePoint([0.5, 0.5]),
                              l = (o[0] - e.cropperEl.offsetWidth / 2) >> 31,
                              u = (o[1] - e.cropperEl.offsetHeight / 2) >> 31,
                              c = -2 * ((l ^ u) + u + u + 4) + 8,
                              d = 0;
                            d < e.handles.length;
                            d++
                          ) {
                            var m = e.handles[d],
                              p = m.el.offsetWidth,
                              _ = m.el.offsetHeight,
                              h = s + t * m.position[0] - p / 2,
                              w = a + n * m.position[1] - _ / 2;
                            (m.el.style.transform =
                              "translate(" +
                              Math.round(h) +
                              "px, " +
                              Math.round(w) +
                              "px)"),
                              (m.el.style.zIndex = c == d ? 5 : 4);
                          }
                        });
                      },
                    },
                    {
                      key: "attachHandlerEvents",
                      value: function () {
                        var e = this.eventBus;
                        e.addEventListener(
                          "handlestart",
                          this.onHandleMoveStart.bind(this)
                        ),
                          e.addEventListener(
                            "handlemove",
                            this.onHandleMoveMoving.bind(this)
                          ),
                          e.addEventListener(
                            "handleend",
                            this.onHandleMoveEnd.bind(this)
                          );
                      },
                    },
                    {
                      key: "attachRegionEvents",
                      value: function () {
                        var e = this.eventBus;
                        function t(t) {
                          t.stopPropagation(),
                            e.dispatchEvent(
                              new CustomEvent("regionmove", {
                                detail: {
                                  mouseX: t.clientX,
                                  mouseY: t.clientY,
                                },
                              })
                            );
                        }
                        function n(s) {
                          s.stopPropagation(),
                            document.removeEventListener("mouseup", n),
                            document.removeEventListener("mousemove", t),
                            e.dispatchEvent(
                              new CustomEvent("regionend", {
                                detail: {
                                  mouseX: s.clientX,
                                  mouseY: s.clientY,
                                },
                              })
                            );
                        }
                        this.regionEl.addEventListener(
                          "mousedown",
                          function (s) {
                            s.stopPropagation(),
                              document.addEventListener("mouseup", n),
                              document.addEventListener("mousemove", t),
                              e.dispatchEvent(
                                new CustomEvent("regionstart", {
                                  detail: {
                                    mouseX: s.clientX,
                                    mouseY: s.clientY,
                                  },
                                })
                              );
                          }
                        ),
                          e.addEventListener(
                            "regionstart",
                            this.onRegionMoveStart.bind(this)
                          ),
                          e.addEventListener(
                            "regionmove",
                            this.onRegionMoveMoving.bind(this)
                          ),
                          e.addEventListener(
                            "regionend",
                            this.onRegionMoveEnd.bind(this)
                          );
                      },
                    },
                    {
                      key: "attachOverlayEvents",
                      value: function () {
                        var e = this,
                          t = null;
                        function n(t) {
                          t.stopPropagation(),
                            e.eventBus.dispatchEvent(
                              new CustomEvent("handlemove", {
                                detail: {
                                  mouseX: t.clientX,
                                  mouseY: t.clientY,
                                },
                              })
                            );
                        }
                        function s(a) {
                          a.stopPropagation(),
                            document.removeEventListener("mouseup", s),
                            document.removeEventListener("mousemove", n),
                            1 !== e.box.width() || 1 !== e.box.height()
                              ? e.eventBus.dispatchEvent(
                                  new CustomEvent("handleend", {
                                    detail: {
                                      mouseX: a.clientX,
                                      mouseY: a.clientY,
                                    },
                                  })
                                )
                              : (e.box = t);
                        }
                        this.overlayEl.addEventListener(
                          "mousedown",
                          function (a) {
                            a.stopPropagation(),
                              document.addEventListener("mouseup", s),
                              document.addEventListener("mousemove", n);
                            var i = e.cropperEl.getBoundingClientRect(),
                              o = a.clientX - i.left,
                              l = a.clientY - i.top;
                            (t = e.box),
                              (e.box = new r(o, l, o + 1, l + 1)),
                              e.eventBus.dispatchEvent(
                                new CustomEvent("handlestart", {
                                  detail: { handle: e.handles[4] },
                                })
                              );
                          }
                        );
                      },
                    },
                    {
                      key: "onHandleMoveStart",
                      value: function (e) {
                        var t = e.detail.handle,
                          n = [1 - t.position[0], 1 - t.position[1]],
                          s = this.box.getAbsolutePoint(n),
                          i = a(s, 2),
                          r = i[0],
                          o = i[1];
                        (this.activeHandle = {
                          handle: t,
                          originPoint: n,
                          originX: r,
                          originY: o,
                        }),
                          null !== this.options.onCropStart &&
                            this.options.onCropStart(this.getValue());
                      },
                    },
                    {
                      key: "onHandleMoveMoving",
                      value: function (e) {
                        var t = e.detail,
                          n = t.mouseX,
                          s = t.mouseY,
                          a = this.cropperEl.getBoundingClientRect();
                        (n -= a.left),
                          (s -= a.top),
                          n < 0 ? (n = 0) : n > a.width && (n = a.width),
                          s < 0 ? (s = 0) : s > a.height && (s = a.height);
                        var i = this.activeHandle.originPoint.slice(),
                          o = this.activeHandle.originX,
                          l = this.activeHandle.originY,
                          u = this.activeHandle.handle,
                          c = 1 === u.constraints[0],
                          d = 1 === u.constraints[1],
                          m = 1 === u.constraints[2],
                          p = 1 === u.constraints[3],
                          _ = (p || d) && (c || m),
                          h = p || d ? o : this.box.x1,
                          w = p || d ? o : this.box.x2,
                          g = c || m ? l : this.box.y1,
                          f = c || m ? l : this.box.y2;
                        (h = p ? n : h),
                          (w = d ? n : w),
                          (g = c ? s : g),
                          (f = m ? s : f);
                        var v = !1,
                          y = !1;
                        if (
                          ((p || d) && (v = p ? n > o : n < o),
                          (c || m) && (y = c ? s > l : s < l),
                          v)
                        ) {
                          var b = h;
                          (h = w), (w = b), (i[0] = 1 - i[0]);
                        }
                        if (y) {
                          var k = g;
                          (g = f), (f = k), (i[1] = 1 - i[1]);
                        }
                        var q = new r(h, g, w, f);
                        if (this.options.aspectRatio) {
                          var x = this.options.aspectRatio,
                            N = !1;
                          _
                            ? (N =
                                s > q.y1 + x * q.width() ||
                                s < q.y2 - x * q.width())
                            : (c || m) && (N = !0);
                          var z = N ? "width" : "height";
                          q.constrainToRatio(x, i, z);
                        }
                        var O = this.options.minSize,
                          S = this.options.maxSize;
                        q.constrainToSize(
                          S.width,
                          S.height,
                          O.width,
                          O.height,
                          i,
                          this.options.aspectRatio
                        );
                        var E = this.cropperEl.offsetWidth,
                          P = this.cropperEl.offsetHeight;
                        q.constrainToBoundary(E, P, i),
                          (this.box = q),
                          this.redraw(),
                          null !== this.options.onCropMove &&
                            this.options.onCropMove(this.getValue());
                      },
                    },
                    {
                      key: "onHandleMoveEnd",
                      value: function (e) {
                        null !== this.options.onCropEnd &&
                          this.options.onCropEnd(this.getValue());
                      },
                    },
                    {
                      key: "onRegionMoveStart",
                      value: function (e) {
                        var t = e.detail,
                          n = t.mouseX,
                          s = t.mouseY,
                          a = this.cropperEl.getBoundingClientRect();
                        (n -= a.left),
                          (s -= a.top),
                          (this.currentMove = {
                            offsetX: n - this.box.x1,
                            offsetY: s - this.box.y1,
                          }),
                          null !== this.options.onCropStart &&
                            this.options.onCropStart(this.getValue());
                      },
                    },
                    {
                      key: "onRegionMoveMoving",
                      value: function (e) {
                        var t = e.detail,
                          n = t.mouseX,
                          s = t.mouseY,
                          a = this.currentMove,
                          i = a.offsetX,
                          r = a.offsetY,
                          o = this.cropperEl.getBoundingClientRect();
                        (n -= o.left),
                          (s -= o.top),
                          this.box.move(n - i, s - r),
                          this.box.x1 < 0 && this.box.move(0, null),
                          this.box.x2 > o.width &&
                            this.box.move(o.width - this.box.width(), null),
                          this.box.y1 < 0 && this.box.move(null, 0),
                          this.box.y2 > o.height &&
                            this.box.move(null, o.height - this.box.height()),
                          this.redraw(),
                          null !== this.options.onCropMove &&
                            this.options.onCropMove(this.getValue());
                      },
                    },
                    {
                      key: "onRegionMoveEnd",
                      value: function (e) {
                        null !== this.options.onCropEnd &&
                          this.options.onCropEnd(this.getValue());
                      },
                    },
                    {
                      key: "getValue",
                      value: function () {
                        var e =
                          arguments.length > 0 && void 0 !== arguments[0]
                            ? arguments[0]
                            : null;
                        if (
                          (null === e && (e = this.options.returnMode),
                          "real" == e)
                        ) {
                          var t = this.imageEl.naturalWidth,
                            n = this.imageEl.naturalHeight,
                            s = this.imageEl.getBoundingClientRect(),
                            a = t / s.width,
                            i = n / s.height;
                          return {
                            x: Math.round(this.box.x1 * a),
                            y: Math.round(this.box.y1 * i),
                            width: Math.round(this.box.width() * a),
                            height: Math.round(this.box.height() * i),
                          };
                        }
                        if ("ratio" == e) {
                          var r = this.imageEl.getBoundingClientRect(),
                            o = r.width,
                            l = r.height;
                          return {
                            x: c(this.box.x1 / o, 3),
                            y: c(this.box.y1 / l, 3),
                            width: c(this.box.width() / o, 3),
                            height: c(this.box.height() / l, 3),
                          };
                        }
                        if ("raw" == e)
                          return {
                            x: Math.round(this.box.x1),
                            y: Math.round(this.box.y1),
                            width: Math.round(this.box.width()),
                            height: Math.round(this.box.height()),
                          };
                      },
                    },
                  ],
                  [
                    {
                      key: "parseOptions",
                      value: function (e) {
                        var t = null,
                          n = { width: null, height: null },
                          s = { width: null, height: null },
                          a = { width: 100, height: 100, unit: "%" },
                          i = "real",
                          r = null,
                          o = null,
                          l = null,
                          u = null,
                          c = null;
                        void 0 !== e.aspectRatio &&
                          ("number" == typeof e.aspectRatio
                            ? (c = e.aspectRatio)
                            : e.aspectRatio instanceof Array &&
                              (c = e.aspectRatio[1] / e.aspectRatio[0]));
                        var d = null;
                        void 0 !== e.maxSize &&
                          null !== e.maxSize &&
                          (d = {
                            width: e.maxSize[0] || null,
                            height: e.maxSize[1] || null,
                            unit: e.maxSize[2] || "px",
                          });
                        var m = null;
                        void 0 !== e.minSize &&
                          null !== e.minSize &&
                          (m = {
                            width: e.minSize[0] || null,
                            height: e.minSize[1] || null,
                            unit: e.minSize[2] || "px",
                          });
                        var p = null;
                        void 0 !== e.startSize &&
                          null !== e.startSize &&
                          (p = {
                            width: e.startSize[0] || null,
                            height: e.startSize[1] || null,
                            unit: e.startSize[2] || "%",
                          });
                        var _ = null;
                        "function" == typeof e.onInitialize &&
                          (_ = e.onInitialize);
                        var h = null;
                        "function" == typeof e.onCropStart &&
                          (h = e.onCropStart);
                        var w = null;
                        "function" == typeof e.onCropEnd && (w = e.onCropEnd);
                        var g = null;
                        "function" == typeof e.onUpdate &&
                          (console.warn(
                            "Croppr.js: `onUpdate` is deprecated and will be removed in the next major release. Please use `onCropMove` or `onCropEnd` instead."
                          ),
                          (g = e.onUpdate)),
                          "function" == typeof e.onCropMove &&
                            (g = e.onCropMove);
                        var f = null;
                        if (void 0 !== e.returnMode) {
                          var v = e.returnMode.toLowerCase();
                          if (-1 === ["real", "ratio", "raw"].indexOf(v))
                            throw "Invalid return mode.";
                          f = v;
                        }
                        var y = function (e, t) {
                          return null !== e ? e : t;
                        };
                        return {
                          aspectRatio: y(c, t),
                          maxSize: y(d, n),
                          minSize: y(m, s),
                          startSize: y(p, a),
                          returnMode: y(f, i),
                          onInitialize: y(_, r),
                          onCropStart: y(h, o),
                          onCropMove: y(g, l),
                          onCropEnd: y(w, u),
                          convertToPixels: function (e) {
                            for (
                              var t = e.offsetWidth,
                                n = e.offsetHeight,
                                s = ["maxSize", "minSize", "startSize"],
                                a = 0;
                              a < s.length;
                              a++
                            ) {
                              var i = s[a];
                              null !== this[i] &&
                                ("%" == this[i].unit &&
                                  (null !== this[i].width &&
                                    (this[i].width = (this[i].width / 100) * t),
                                  null !== this[i].height &&
                                    (this[i].height =
                                      (this[i].height / 100) * n)),
                                delete this[i].unit);
                            }
                          },
                        };
                      },
                    },
                  ]
                ),
                n
              );
            })();
          function c(e, t) {
            return Number(Math.round(e + "e" + t) + "e-" + t);
          }
          var d = (function (a) {
            function i(t, n) {
              var a =
                arguments.length > 2 && void 0 !== arguments[2] && arguments[2];
              return (
                e(this, i),
                s(
                  this,
                  (i.__proto__ || Object.getPrototypeOf(i)).call(this, t, n, a)
                )
              );
            }
            return (
              (function (e, t) {
                if ("function" != typeof t && null !== t)
                  throw new TypeError(
                    "Super expression must either be null or a function, not " +
                      typeof t
                  );
                (e.prototype = Object.create(t && t.prototype, {
                  constructor: {
                    value: e,
                    enumerable: !1,
                    writable: !0,
                    configurable: !0,
                  },
                })),
                  t &&
                    (Object.setPrototypeOf
                      ? Object.setPrototypeOf(e, t)
                      : (e.__proto__ = t));
              })(i, a),
              t(i, [
                {
                  key: "getValue",
                  value: function (e) {
                    return n(
                      i.prototype.__proto__ ||
                        Object.getPrototypeOf(i.prototype),
                      "getValue",
                      this
                    ).call(this, e);
                  },
                },
                {
                  key: "setImage",
                  value: function (e) {
                    return n(
                      i.prototype.__proto__ ||
                        Object.getPrototypeOf(i.prototype),
                      "setImage",
                      this
                    ).call(this, e);
                  },
                },
                {
                  key: "destroy",
                  value: function () {
                    return n(
                      i.prototype.__proto__ ||
                        Object.getPrototypeOf(i.prototype),
                      "destroy",
                      this
                    ).call(this);
                  },
                },
                {
                  key: "moveTo",
                  value: function (e, t) {
                    return (
                      this.box.move(e, t),
                      this.redraw(),
                      null !== this.options.onCropEnd &&
                        this.options.onCropEnd(this.getValue()),
                      this
                    );
                  },
                },
                {
                  key: "resizeTo",
                  value: function (e, t) {
                    var n =
                      arguments.length > 2 && void 0 !== arguments[2]
                        ? arguments[2]
                        : [0.5, 0.5];
                    return (
                      this.box.resize(e, t, n),
                      this.redraw(),
                      null !== this.options.onCropEnd &&
                        this.options.onCropEnd(this.getValue()),
                      this
                    );
                  },
                },
                {
                  key: "scaleBy",
                  value: function (e) {
                    var t =
                      arguments.length > 1 && void 0 !== arguments[1]
                        ? arguments[1]
                        : [0.5, 0.5];
                    return (
                      this.box.scale(e, t),
                      this.redraw(),
                      null !== this.options.onCropEnd &&
                        this.options.onCropEnd(this.getValue()),
                      this
                    );
                  },
                },
                {
                  key: "reset",
                  value: function () {
                    return (
                      (this.box = this.initializeBox(this.options)),
                      this.redraw(),
                      null !== this.options.onCropEnd &&
                        this.options.onCropEnd(this.getValue()),
                      this
                    );
                  },
                },
              ]),
              i
            );
          })(u);
          return d;
        })();
      },
    },
    t = {};
  function n(s) {
    var a = t[s];
    if (void 0 !== a) return a.exports;
    var i = (t[s] = { exports: {} });
    return e[s].call(i.exports, i, i.exports, n), i.exports;
  }
  (n.n = (e) => {
    var t = e && e.__esModule ? () => e.default : () => e;
    return n.d(t, { a: t }), t;
  }),
    (n.d = (e, t) => {
      for (var s in t)
        n.o(t, s) &&
          !n.o(e, s) &&
          Object.defineProperty(e, s, { enumerable: !0, get: t[s] });
    }),
    (n.o = (e, t) => Object.prototype.hasOwnProperty.call(e, t)),
    (() => {
      "use strict";
      const {
          createElement: e,
          render: t,
          useState: s,
          useEffect: a,
          Fragment: i,
        } = wp.element,
        { select: r, dispatch: o } = wp.data,
        l = (t) => {
          const [n, o] = s(!1),
            [l, u] = s(!1),
            c = r("vibebp").getToken();
          return (
            a(() => {
              o(!0);
            }, [t]),
            e(
              i,
              null,
              n
                ? e(
                    "div",
                    {
                      className: "popup_wrapper",
                      onClick: (e) => {
                        e.preventDefault(),
                          document.querySelector(".popup_wrapper") &&
                            e.target ===
                              document.querySelector(".popup_wrapper") &&
                            o(!1);
                      },
                    },
                    e(
                      "div",
                      { className: "popup_content" },
                      e("span", {
                        className: "vicon vicon-close",
                        onClick: () => {
                          o(!1);
                        },
                      }),
                      e(
                        "h3",
                        null,
                        window.wplms_course_data.translations.apply_to_course
                      ),
                      e(
                        "div",
                        { className: "popup-footer" },
                        e(
                          "a",
                          {
                            className: "button is-primary",
                            onClick: () => {
                              u(!0),
                                fetch(
                                  `${window.wplms_course_data.api_url}/student/courseButton/applycourse`,
                                  {
                                    method: "post",
                                    body: JSON.stringify({
                                      id: t.id,
                                      token: c,
                                    }),
                                  }
                                )
                                  .then((e) => e.json())
                                  .then((e) => {
                                    if (e.status) {
                                      o(!1), u(!1);
                                      var n = new CustomEvent(
                                        "wplms_popup_applied",
                                        {
                                          detail: {
                                            course: t.id,
                                            text: e.message,
                                          },
                                        }
                                      );
                                      document.dispatchEvent(n);
                                    }
                                  });
                            },
                          },
                          window.wplms_course_data.translations.yes
                        ),
                        e(
                          "a",
                          {
                            className: "button is-primary",
                            onClick: () => {
                              o(!1);
                            },
                          },
                          window.wplms_course_data.translations.cancel
                        )
                      )
                    )
                  )
                : ""
            )
          );
        },
        { createElement: u, render: c } = wp.element,
        d = (e) =>
          u(
            "div",
            { class: "lds-ellipsis" },
            u("div", null),
            u("div", null),
            u("div", null),
            u("div", null)
          ),
        {
          createElement: m,
          useState: p,
          useEffect: _,
          Fragment: h,
          render: w,
        } = wp.element,
        g = ({ progress: e, size: t }) => {
          let n, s;
          switch (t) {
            case "xs":
              (n = 10), (s = 1);
              break;
            case "s":
              (n = 12), (s = 1.2);
              break;
            case "sm":
              (n = 25), (s = 2.5);
              break;
            case "med":
            default:
              (n = 50), (s = 5);
              break;
            case "lg":
              (n = 75), (s = 7.5);
              break;
            case "xl":
              (n = 100), (s = 10);
          }
          const a = n - 2 * s,
            i = 2 * a * Math.PI,
            r = i - (e / 100) * i;
          return m(
            "div",
            { className: "react-progress-circle" },
            m(
              "svg",
              { height: 2 * n, width: 2 * n },
              m("circle", {
                className: "ReactProgressCircle_circleBackground",
                strokeWidth: s,
                style: { strokeDashoffset: r },
                r: a,
                cx: n,
                cy: n,
              }),
              m("circle", {
                className: "ReactProgressCircle_circle",
                strokeWidth: s,
                strokeDasharray: i + " " + i,
                style: { strokeDashoffset: r },
                r: a,
                cx: n,
                cy: n,
              })
            )
          );
        },
        { createContext: f } = wp.element,
        v = f({ courseStatus: {}, current_unit_key: 0, update: (e) => {} }),
        {
          createElement: y,
          useState: b,
          useEffect: k,
          Fragment: q,
          render: x,
          useContext: N,
        } = wp.element,
        { dispatch: z, select: O } = wp.data,
        S = (e) => {
          const t = N(v),
            [n, s] = b([]),
            [a, i] = b(0);
          k(() => {
            if (
              Array.isArray(t.courseStatus.courseitems) &&
              t.courseStatus.courseitems.length
            ) {
              let e = [...t.courseStatus.courseitems];
              e =
                t.courseStatus &&
                t.courseStatus.filtered_items &&
                t.courseStatus.filtered_items.length
                  ? t.courseStatus.filtered_items
                  : t.courseStatus.courseitems;
              let n = -1;
              e.map((e, s) => {
                "section" == e.type
                  ? (n = s)
                  : n > -1 && t.current_unit_key == s && i(n);
              }),
                n < 0 && i(n),
                s(e);
            }
          }, [
            t.courseStatus.courseitems,
            t.current_unit_key,
            t.courseStatus.filtered_items,
          ]),
            k(() => {
              if (
                Array.isArray(t.courseStatus.courseitems) &&
                t.courseStatus.courseitems.length
              ) {
                let e = -1,
                  n = [...t.courseStatus.courseitems];
                n.map((s, a) => {
                  "section" == s.type
                    ? ((e = a), (n[e].lesson_count = 0), (n[e].duration = 0))
                    : e > -1 &&
                      ((n[e].duration =
                        parseInt(n[e].duration) + parseInt(s.duration)),
                      n[e].lesson_count++,
                      (n[a].section = e),
                      t.current_unit_key == a && i(e));
                }),
                  e < 0 && i(e),
                  s(n);
              }
            }, [t.courseStatus.courseitems]);
          let r = -1;
          return y(
            q,
            null,
            n
              ? y(
                  "ul",
                  { className: n.length > 10 ? "" : "stickypos" },
                  n.map((e, s) => {
                    let o = Math.round(e.duration / 60);
                    "section" == e.type && (r = s);
                    let l =
                      e.type +
                      " " +
                      (e.status ? "done" : "") +
                      " " +
                      (t.current_unit_key == s ? "active" : "") +
                      " ";
                    return (
                      "section" != e.type &&
                        a > -1 &&
                        (l += a === r ? " open_lesson" : " collapsed_lesson"),
                      y(
                        "li",
                        { className: l },
                        y(
                          "p",
                          {
                            onClick: () => {
                              ((e, n) => {
                                "section" == e.type
                                  ? i(n)
                                  : 0 != e.id &&
                                    (document
                                      .querySelector(".course_status")
                                      .scrollTo({
                                        top: 0,
                                        left: 0,
                                        behavior: "smooth",
                                      }),
                                    t.update({ index: n }, "loadunit"));
                              })(e, e.key);
                            },
                          },
                          e.icon && e.icon.length > 200
                            ? y("span", {
                                dangerouslySetInnerHTML: { __html: e.icon },
                              })
                            : y("span", { className: e.icon }),
                          y("span", {
                            className: "lesson_title",
                            dangerouslySetInnerHTML: { __html: e.title },
                          }),
                          "section" == e.type
                            ? y(
                                "span",
                                null,
                                y(
                                  "span",
                                  { className: "lesson_count" },
                                  e.lesson_count +
                                    " " +
                                    window.wplms_course_data.translations
                                      .lesson_count
                                ),
                                y(
                                  "span",
                                  { className: "lesson_duration" },
                                  o < 180
                                    ? o +
                                        " " +
                                        window.wplms_course_data.time_labels
                                          .minute.symbol
                                    : o > 999
                                    ? y("span", {
                                        className: "vicon vicon-infinite",
                                      })
                                    : Math.round(o / 60) +
                                      " " +
                                      window.wplms_course_data.time_labels.hour
                                        .symbol
                                )
                              )
                            : y(
                                "span",
                                { className: "lesson_duration" },
                                o >= 9999
                                  ? y("i", {
                                      className: "vicon vicon-infinite",
                                    })
                                  : o < 180
                                  ? o +
                                    " " +
                                    window.wplms_course_data.time_labels.minute
                                      .symbol
                                  : Math.round(o / 60) +
                                    " " +
                                    window.wplms_course_data.time_labels.hour
                                      .symbol
                              )
                        ),
                        "section" == e.type
                          ? y(
                              "i",
                              s === a
                                ? {
                                    className: "vicon vicon-minus",
                                    onClick: () => i(!1),
                                  }
                                : {
                                    className: "vicon vicon-plus",
                                    onClick: () => i(s),
                                  }
                            )
                          : "",
                        "section" != e.type
                          ? "unit" === e.type
                            ? y(
                                "div",
                                {
                                  className: "unit_progress_wrapper",
                                  onClick: () => {
                                    ((e, n) => {
                                      0 == e.id ||
                                        t.courseStatus.lock ||
                                        e.status ||
                                        (t.courseStatus.unit_media_lock &&
                                          ((e.meta.hasOwnProperty("video") &&
                                            Array.isArray(e.meta.video) &&
                                            e.meta.video.length) ||
                                            "video" == e.unit_type)) ||
                                        t.update(
                                          { index: n },
                                          "directmarkcomplete"
                                        );
                                    })(e, s);
                                  },
                                },
                                t.courseStatus.hasOwnProperty("lock") &&
                                  t.courseStatus.lock &&
                                  !t.courseStatus.courseitems[s].status &&
                                  s != t.current_unit_key
                                  ? y("span", { className: "vicon vicon-lock" })
                                  : y(g, {
                                      progress:
                                        n[s] &&
                                        "unit" == n[s].type &&
                                        n[s].hasOwnProperty("progressbar")
                                          ? n[s].progressbar
                                          : 0,
                                      size: "xs",
                                    })
                              )
                            : y(
                                "div",
                                { className: "unit_progress_wrapper" },
                                t.courseStatus.hasOwnProperty("lock") &&
                                  t.courseStatus.lock &&
                                  !t.courseStatus.courseitems[s].status &&
                                  s != t.current_unit_key
                                  ? y("span", { className: "vicon vicon-lock" })
                                  : y(g, { progress: 100, size: "xs" })
                              )
                          : ""
                      )
                    );
                  })
                )
              : y(
                  "div",
                  { class: "message" },
                  window.wplms_course_data.translations.no_content_found
                )
          );
        },
        {
          Component: E,
          createElement: P,
          render: I,
          useState: C,
          useEffect: M,
          Fragment: L,
        } = wp.element,
        T = (e) => {
          const [t, n] = C(e.duration),
            [s, a] = C({ d: 0, h: 0, m: 0, s: 0 });
          M(() => {
            e.start
              ? setTimeout(() => {
                  let s = t - 1;
                  s <= -1
                    ? e.update(e.question, "expired")
                    : s >= 0 && (n(s), i());
                }, 1e3)
              : (n(e.duration), i());
          }, [t, e.start, e.duration]);
          const i = () => {
            let e = { ...s },
              n = t;
            n > 86400
              ? ((e.d = Math.floor(n / 86400)), (n -= 86400 * e.d))
              : (e.d = 0),
              n > 3600
                ? ((e.h = Math.floor(n / 3600)), (n -= 3600 * e.h))
                : (e.h = 0),
              n > 60
                ? ((e.m = Math.floor(n / 60)), (n -= 60 * e.m))
                : (e.m = 0),
              (e.s = n),
              a(e);
          };
          let r = 0;
          return (
            t > -1 &&
              ((r = Math.floor(
                ((e.question.question_duration - t) /
                  e.question.question_duration) *
                  100
              )),
              r <= 0 && (r = 1)),
            P(
              "div",
              { className: "QuestionDuration" },
              P(
                "div",
                { className: "question_timer" },
                P(
                  "div",
                  { className: "question-duration-progress" },
                  P("span", { style: { width: 100 - r + "%" } })
                ),
                P(
                  "span",
                  null,
                  P(
                    "span",
                    { className: "question_timer_amount" },
                    s.m
                      ? P(
                          L,
                          null,
                          P(
                            "span",
                            null,
                            s.m.toString().length < 2 ? "0" + s.m : s.m
                          ),
                          P("span", null, ":")
                        )
                      : P(L, null, P("span", null, "00"), P("span", null, ":")),
                    s.s
                      ? P(
                          L,
                          null,
                          P(
                            "span",
                            null,
                            s.s.toString().length < 2 ? "0" + s.s : s.s
                          )
                        )
                      : "00"
                  )
                )
              )
            )
          );
        },
        {
          Component: A,
          createElement: D,
          render: $,
          useState: F,
          useEffect: j,
          Fragment: H,
        } = wp.element,
        B = (e) => {
          const [t, n] = F(e.duration),
            [s, a] = F({ d: 0, h: 0, m: 0, s: 0 });
          j(() => {
            e.start
              ? setTimeout(() => {
                  let s = t - 1;
                  s <= -1
                    ? e.update(e.quiz_id, "expired")
                    : s >= 0 && (n(s), i());
                }, 1e3)
              : (n(e.duration), i());
          }, [t, e.start, e.duration]);
          const i = () => {
            let e = { ...s },
              n = t;
            n > 86400
              ? ((e.d = Math.floor(n / 86400)), (n -= 86400 * e.d))
              : (e.d = 0),
              n > 3600
                ? ((e.h = Math.floor(n / 3600)), (n -= 3600 * e.h))
                : (e.h = 0),
              n > 60
                ? ((e.m = Math.floor(n / 60)), (n -= 60 * e.m))
                : (e.m = 0),
              (e.s = n),
              a(e);
          };
          let r = 0;
          return (
            t > -1 &&
              ((r = Math.floor(((e.duration - t) / e.duration) * 100)),
              r <= 0 && (r = 1)),
            D(
              "div",
              { className: "quiztimer" },
              D(
                "div",
                { className: "circle_timer" },
                r
                  ? D(g, {
                      size: window.innerWidth < 480 ? "xs" : "sm",
                      progress: r,
                    })
                  : "",
                D(
                  "span",
                  null,
                  D(
                    "span",
                    { className: "timer_amount" },
                    s.d
                      ? D(H, null, D("span", null, s.d), D("span", null, ":"))
                      : "",
                    s.h
                      ? D(H, null, D("span", null, s.h), D("span", null, ":"))
                      : "",
                    s.m
                      ? D(H, null, D("span", null, s.m), D("span", null, ":"))
                      : "",
                    D("span", null, s.s)
                  ),
                  D(
                    "span",
                    { className: "timer_unit" },
                    s.d
                      ? D(
                          H,
                          null,
                          D(
                            "span",
                            null,
                            window.wplms_course_data.translations.days
                          ),
                          D("span", null)
                        )
                      : "",
                    s.h
                      ? D(
                          H,
                          null,
                          D(
                            "span",
                            null,
                            window.wplms_course_data.translations.hours
                          ),
                          D("span", null)
                        )
                      : "",
                    s.m
                      ? D(
                          H,
                          null,
                          D(
                            "span",
                            null,
                            window.wplms_course_data.translations.minutes
                          ),
                          D("span", null)
                        )
                      : "",
                    D(
                      "span",
                      null,
                      window.wplms_course_data.translations.seconds
                    )
                  )
                )
              )
            )
          );
        },
        {
          createElement: R,
          render: U,
          useState: J,
          useEffect: X,
          useContext: W,
          Fragment: Y,
          RawHTML: V,
        } = wp.element,
        { dispatch: Q, select: K } = wp.data,
        G = (e) => {
          const [t, n] = J(e.timestamp),
            [s, a] = J(0);
          let i = Math.floor(Date.now() / 1e3);
          return (
            X(() => {
              e.time && a(e.time);
            }, [e.time]),
            X(() => {
              if ((n(parseInt(e.timestamp)), e.timestamp))
                if (e.hasOwnProperty("notimediff")) a(parseInt(e.timestamp));
                else {
                  let t = e.timestamp,
                    n = e.timestamp.toString();
                  n.includes("-") &&
                    ((t = (function (e) {
                      const t = Date.parse(e);
                      return isNaN(t)
                        ? "string" == typeof e
                          ? Date.parse(
                              e.replace(/-/g, "/").replace(/[a-z]+/gi, " ")
                            )
                          : e
                        : t;
                    })(n)),
                    (t /= 1e3)),
                    parseInt(t) > i ? a(parseInt(t) - i) : a(i - parseInt(t));
                }
            }, [e.timestamp]),
            R(
              "span",
              { className: "friendly_time" },
              (() => {
                if (s < 0) return window.wplms_course_data.translations.expired;
                let t,
                  n,
                  a,
                  i = 0,
                  r = 0,
                  o = 0,
                  l = [
                    {
                      label: window.wplms_course_data.time_labels.year.single,
                      multi: window.wplms_course_data.time_labels.year.multi,
                      value: 31536e3,
                    },
                    {
                      label: window.wplms_course_data.time_labels.month.single,
                      multi: window.wplms_course_data.time_labels.month.multi,
                      value: 2592e3,
                      max: 12,
                    },
                    {
                      label: window.wplms_course_data.time_labels.week.single,
                      multi: window.wplms_course_data.time_labels.week.multi,
                      value: 604800,
                      max: 7,
                    },
                    {
                      label: window.wplms_course_data.time_labels.day.single,
                      multi: window.wplms_course_data.time_labels.day.multi,
                      value: 86400,
                      max: 31,
                    },
                    {
                      label: window.wplms_course_data.time_labels.hour.single,
                      multi: window.wplms_course_data.time_labels.hour.multi,
                      value: 3600,
                      max: 24,
                    },
                    {
                      label: window.wplms_course_data.time_labels.minute.single,
                      multi: window.wplms_course_data.time_labels.minute.multi,
                      value: 60,
                      max: 60,
                    },
                    {
                      label: window.wplms_course_data.time_labels.second.single,
                      multi: window.wplms_course_data.time_labels.second.multi,
                      value: 1,
                      max: 60,
                    },
                  ];
                if (s >= 776736e3)
                  return window.wplms_course_data.translations.unlimited_time;
                if (s <= 0)
                  return e.hasOwnProperty("notimediff")
                    ? s +
                        " " +
                        window.wplms_course_data.time_labels.second.multi
                    : window.wplms_course_data.translations.just_now;
                for (let e = 0; e < l.length; e++)
                  if (((n = l[e]), (r = e), n.value < s)) {
                    (i = Math.floor(s / n.value)), i > n.max && (i = n.max);
                    break;
                  }
                return (
                  (t = i + " " + (i > 1 ? n.multi : n.label)),
                  n.value > 1 &&
                    ((a = l[r + 1]),
                    (o = Math.floor((s % n.value) / a.value)),
                    o && (t += ", " + o + " " + (o > 1 ? a.multi : a.label))),
                  t
                );
              })()
            )
          );
        },
        {
          createElement: Z,
          render: ee,
          useState: te,
          useEffect: ne,
          Fragment: se,
        } = wp.element,
        ae = (e) => {
          const [t, n] = te({});
          ne(() => {
            n(e.question);
          }, [e.question]);
          let s = "";
          t.hasOwnProperty("marked_answer") && (s = t.marked_answer);
          let a = "";
          return (
            t.hasOwnProperty("usercorrect") &&
              t.show_correct_answer &&
              ((a = "question_incorrect"),
              t.usercorrect > 0 && (a = "question_correct")),
            Z(
              se,
              null,
              Z("div", {
                className: "question_content",
                dangerouslySetInnerHTML: {
                  __html: t && t.content ? t.content : "",
                },
              }),
              Z("input", {
                type: "text",
                className: a,
                value: s,
                onChange: (s) => {
                  let a = { ...e.question };
                  t?.expired ||
                    ((a.marked_answer = s.target.value),
                    n(a),
                    e.update(a, e.index, "changed"));
                },
              })
            )
          );
        },
        {
          createElement: ie,
          render: re,
          useState: oe,
          useEffect: le,
          Fragment: ue,
        } = wp.element,
        ce = (e) => {
          const [t, n] = oe({}),
            [s, a] = oe([]);
          le(() => {
            if (
              (n(e.question),
              e.question.hasOwnProperty("options") &&
                e.question.options.length &&
                Array.isArray(e.question.options))
            ) {
              let t = [...e.question.options];
              window.wplms_course_data.question_option_rearrange && i(t), a(t);
            }
          }, [e.question.options, e.question.correct_indexes]);
          const i = (e) => {
            for (var t = e.length - 1; t > 0; t--) {
              var n = Math.floor(Math.random() * (t + 1)),
                s = e[t];
              (e[t] = e[n]), (e[n] = s);
            }
          };
          let r = "";
          return (
            t.hasOwnProperty("marked_answer") && t.marked_answer,
            ie(
              ue,
              null,
              ie("div", {
                className: "question_content",
                dangerouslySetInnerHTML: {
                  __html: t && t.content ? t.content : "",
                },
              }),
              t.options && t.options.length
                ? ie(
                    ue,
                    null,
                    ((t) =>
                      s.map(function (s, a) {
                        let i = t.options.findIndex((e) => e == s);
                        return ie(
                          "div",
                          {
                            className:
                              "question_option radio " +
                              (t.show_correct_answer && t.correct_indexes
                                ? t.correct_indexes &&
                                  t.correct_indexes.length &&
                                  t.correct_indexes.includes(i)
                                  ? "question_correct"
                                  : "question_incorrect"
                                : ""),
                          },
                          ie("input", {
                            type: "radio",
                            name: e.quiz_id + "_" + t.id,
                            value: i,
                            id: e.quiz_id + "_" + t.id + i,
                            checked: parseInt(t.marked_answer) === i,
                            onChange: (s) => {
                              let a = { ...t };
                              e?.question?.expired ||
                                ((a.marked_answer = s.target.value),
                                n(a),
                                e.update(a, e.index, "changed"));
                            },
                          }),
                          ie("label", {
                            for: e.quiz_id + "_" + t.id + i,
                            dangerouslySetInnerHTML: { __html: s },
                          })
                        );
                      }))(t),
                    t.attempted
                      ? ""
                      : ie(
                          "span",
                          {
                            className: "resetq_answer button",
                            onClick: (t) => {
                              let s = { ...e.question };
                              (s.marked_answer = null),
                                n(s),
                                e.update(s, e.index, "changed");
                            },
                          },
                          ie("i", { class: "vicon vicon-trash" })
                        )
                  )
                : ""
            )
          );
        },
        {
          createElement: de,
          render: me,
          useState: pe,
          useEffect: _e,
          Fragment: he,
        } = wp.element,
        we = (e) => {
          const [t, n] = pe({}),
            [s, a] = pe(-1);
          _e(() => {
            n(e.question);
          }, [e.question]);
          const i = (s, i) => {
            if (t?.expired) return;
            let r = { ...e.question };
            (r.marked_answer && r.marked_answer.length) ||
              (r.marked_answer = []),
              (r.marked_answer[i] = s),
              n(r),
              e.update(r, e.index, "changed"),
              a(-1);
          };
          return de(
            he,
            null,
            t && t.extra_content && Array.isArray(t.extra_content)
              ? de(
                  "div",
                  { className: "question_content" },
                  t.extra_content.map(function (n, r) {
                    return de(
                      he,
                      null,
                      de("span", {
                        className: "select_question_content",
                        dangerouslySetInnerHTML: { __html: n },
                      }),
                      t.options &&
                        t.options.length &&
                        r < t.extra_content.length - 1
                        ? de(
                            he,
                            null,
                            ((t, n) =>
                              de(
                                he,
                                null,
                                de(
                                  "span",
                                  {
                                    className:
                                      t.show_correct_answer && t.correct_indexes
                                        ? t.correct_indexes &&
                                          t.correct_indexes.length &&
                                          t.correct_indexes.includes(n)
                                          ? "question_correct"
                                          : "question_incorrect"
                                        : "",
                                  },
                                  s === n
                                    ? de(
                                        "select",
                                        {
                                          name: e.quiz_id + "_" + t.id,
                                          id: e.quiz_id + "_" + t.id,
                                          onChange: (e) => {
                                            t?.expired || i(e.target.value, n);
                                          },
                                        },
                                        de(
                                          "option",
                                          null,
                                          window.wplms_course_data.translations
                                            .select_option
                                        ),
                                        ((e, t) =>
                                          e.options.map(function (n, s) {
                                            return e.hasOwnProperty(
                                              "options_arr"
                                            ) &&
                                              e.options_arr &&
                                              e.options_arr.length &&
                                              e.options_arr[t] &&
                                              e.options_arr[t].length
                                              ? e.options_arr[t].includes(
                                                  (s + 1).toString()
                                                ) ||
                                                e.options_arr[t].includes(s + 1)
                                                ? de("option", {
                                                    value: s,
                                                    selected:
                                                      e.marked_answer &&
                                                      e.marked_answer.length &&
                                                      e.marked_answer[t] &&
                                                      parseInt(
                                                        e.marked_answer[t]
                                                      ) === s,
                                                    dangerouslySetInnerHTML: {
                                                      __html: n,
                                                    },
                                                  })
                                                : void 0
                                              : de("option", {
                                                  value: s,
                                                  selected:
                                                    e.marked_answer &&
                                                    e.marked_answer.length &&
                                                    e.marked_answer[t] &&
                                                    parseInt(
                                                      e.marked_answer[t]
                                                    ) === s,
                                                  dangerouslySetInnerHTML: {
                                                    __html: n,
                                                  },
                                                });
                                          }))(t, n)
                                      )
                                    : t.options.length &&
                                      t.hasOwnProperty("marked_answer") &&
                                      t.marked_answer.length &&
                                      t.marked_answer[n]
                                    ? de("span", {
                                        className: "selectimitate ",
                                        dangerouslySetInnerHTML: {
                                          __html: t.options[t.marked_answer[n]],
                                        },
                                        onClick: () => {
                                          t?.expired || a(n);
                                        },
                                      })
                                    : de("span", {
                                        className: "selectimitate no_value",
                                        onClick: () => {
                                          a(n);
                                        },
                                      })
                                ),
                                t.attempted
                                  ? ""
                                  : de(
                                      "span",
                                      {
                                        className: "resetq_answer button",
                                        onClick: (e) => {
                                          i(null, n);
                                        },
                                      },
                                      de("i", { class: "vicon vicon-trash" })
                                    )
                              ))(t, r)
                          )
                        : ""
                    );
                  })
                )
              : ""
          );
        },
        {
          createElement: ge,
          render: fe,
          useState: ve,
          useEffect: ye,
          Fragment: be,
        } = wp.element,
        ke = (e) => {
          const [t, n] = ve({}),
            [s, a] = ve([]);
          ("undefined" != e.question.marked_answer &&
            null != e.question.marked_answer) ||
            (e.question.marked_answer = []),
            ye(() => {
              if (
                (n(e.question),
                e.question.hasOwnProperty("options") &&
                  e.question.options.length &&
                  Array.isArray(e.question.options))
              ) {
                let t = [...e.question.options];
                window.wplms_course_data.question_option_rearrange && i(t),
                  a(t);
              }
            }, [e.question.options, e.question.correct_indexes]);
          const i = (e) => {
            for (var t = e.length - 1; t > 0; t--) {
              var n = Math.floor(Math.random() * (t + 1)),
                s = e[t];
              (e[t] = e[n]), (e[n] = s);
            }
          };
          return ge(
            be,
            null,
            ge("div", {
              className: "question_content",
              dangerouslySetInnerHTML: {
                __html: t && t.content ? t.content : "",
              },
            }),
            t.options && t.options.length
              ? ge(
                  be,
                  null,
                  ((t) => {
                    if (s && s.length)
                      return s.map(function (s, a) {
                        let i = t.options.findIndex((e) => e == s);
                        return ge(
                          "div",
                          {
                            className:
                              "question_option checkbox " +
                              (t.show_correct_answer && t.correct_indexes
                                ? t.correct_indexes &&
                                  t.correct_indexes.length &&
                                  t.correct_indexes.includes(i)
                                  ? "question_correct"
                                  : "question_incorrect"
                                : ""),
                          },
                          ge("input", {
                            type: "checkbox",
                            name: e.quiz_id + "_" + t.id,
                            value: i,
                            id: e.quiz_id + "_" + t.id + i,
                            checked:
                              e.question.marked_answer &&
                              e.question.marked_answer.length &&
                              e.question.marked_answer.includes(i),
                            onChange: (s) => {
                              let a = { ...t };
                              if (!e?.question?.expired) {
                                if (a.marked_answer.includes(i)) {
                                  let e = a.marked_answer.indexOf(i);
                                  e > -1 && a.marked_answer.splice(e, 1);
                                } else a.marked_answer.push(i);
                                n(a), e.update(a, e.index, "changed");
                              }
                            },
                          }),
                          ge("label", {
                            for: e.quiz_id + "_" + t.id + i,
                            dangerouslySetInnerHTML: { __html: s },
                          })
                        );
                      });
                  })(t),
                  t.attempted
                    ? ""
                    : ge(
                        "span",
                        {
                          className: "resetq_answer button",
                          onClick: (t) => {
                            let s = { ...e.question };
                            (s.marked_answer = null),
                              n(s),
                              e.update(s, e.index, "changed");
                          },
                        },
                        ge("i", { class: "vicon vicon-trash" })
                      )
                )
              : ""
          );
        },
        {
          createElement: qe,
          render: xe,
          useState: Ne,
          useEffect: ze,
          Fragment: Oe,
        } = wp.element,
        Se = (e) => {
          const [t, n] = Ne("120"),
            [s, a] = Ne(() => {
              let t = "";
              return (
                e.marked_answer &&
                  e.marked_answer.length &&
                  (t = e.marked_answer[e.index]),
                t
              );
            });
          ze(() => {
            void 0 !== s && s && s.length > 15 && n(8 * s.length);
          }, [s]);
          let i = "";
          return (
            s && (i = s),
            qe(
              Oe,
              null,
              qe(
                "div",
                { className: "fillblank_area" },
                qe("input", {
                  type: "text",
                  value: i,
                  onChange: (t) => {
                    if (!e.canedit) return;
                    let n = s;
                    (n = t.target.value), a(n), e.update(n, e.index, "changed");
                  },
                  style: { width: t + "px" },
                })
              )
            )
          );
        },
        {
          createElement: Ee,
          render: Pe,
          useState: Ie,
          useEffect: Ce,
          Fragment: Me,
        } = wp.element,
        Le = (e) => {
          const [t, n] = Ie({});
          Ce(() => {
            n(e.question);
          }, [e.question]);
          let s = "";
          t.hasOwnProperty("marked_answer") && t.marked_answer;
          const a = (s, a, i) => {
            if ("changed" == i) {
              if (e?.question?.expired) return;
              let i = { ...t };
              (i.marked_answer && t.marked_answer.length) ||
                (i.marked_answer = []),
                (i.marked_answer[a] = s),
                n(i),
                e.update(i, e.index, "changed");
            }
          };
          return Ee(
            Me,
            null,
            t && t.extra_content && Array.isArray(t.extra_content)
              ? Ee(
                  "div",
                  { className: "question_content" },
                  t.extra_content.map(function (n, s) {
                    return Ee(
                      Me,
                      null,
                      Ee("span", {
                        className: "select_question_content",
                        dangerouslySetInnerHTML: { __html: n },
                      }),
                      s < t.extra_content.length - 1
                        ? Ee(
                            "div",
                            {
                              className:
                                "fillblank_area " +
                                (t.show_correct_answer && t.correct_indexes
                                  ? t.correct_indexes &&
                                    t.correct_indexes.length &&
                                    t.correct_indexes.includes(s)
                                    ? "question_correct"
                                    : "question_incorrect"
                                  : ""),
                            },
                            Ee(Se, {
                              update: a,
                              index: s,
                              marked_answer: t.marked_answer,
                              canedit: !e?.question?.expired,
                            })
                          )
                        : ""
                    );
                  })
                )
              : ""
          );
        },
        {
          createElement: Te,
          render: Ae,
          useState: De,
          useEffect: $e,
          Fragment: Fe,
        } = wp.element,
        je = (e) => {
          const [t, n] = De([]),
            [s, a] = De(!1),
            [i, r] = De([]),
            [o, l] = De([]),
            [u, c] = De([]),
            [d, m] = De([]);
          $e(() => {
            r(e.items);
          }, [e.items]);
          let p = "droppable";
          s && (p += " active");
          const _ = (e) => {
            let t = "";
            return s === i[e] && (t = "dragging"), t;
          };
          return Te(
            "div",
            { className: p },
            i.map((p, h) =>
              Te(
                "div",
                {
                  key: h,
                  onDragStart: (e) => {
                    i[h] && a(i[h]);
                  },
                  onDragEnd: () => {
                    a(!1);
                  },
                  onDragOver: (t) => {
                    t.preventDefault(),
                      ((t, n) => {
                        if (!s) return;
                        let a = i[n];
                        if (s === a) return;
                        let o = [...i];
                        (o = o.filter((e) => e != s)),
                          o.splice(n, 0, s),
                          r(o),
                          e.update(o, "changed");
                      })(0, h);
                  },
                  ref: (e) => {
                    ((e, s) => {
                      if (e) {
                        let a = t;
                        a[s] || (a[s] = e), n(a);
                      }
                    })(e, h);
                  },
                  draggable: !e.question?.expired,
                  style: d[h],
                  onTouchStart: (e) => {
                    let n = [...u];
                    t.map((e, t) => {
                      let s = e.getBoundingClientRect();
                      n[t] = s;
                    }),
                      c(n),
                      i[h] && a(i[h]);
                  },
                  onTouchMove: (e) => {
                    e.preventDefault();
                    let t = [];
                    if ("touchmove" === e.type) {
                      let n = [...d];
                      (n[h] = {
                        transform:
                          "translateY(" +
                          Math.floor(e.touches[0].clientY - u[h].top) +
                          "px)",
                      }),
                        m(n),
                        t.push(i[h]);
                      let s = [];
                      if (
                        (e.touches[0].clientY &&
                          u.map((n, a) => {
                            n.top + n.height / 2 > e.touches[0].clientY &&
                              i[a] !== i[h] &&
                              t.push(i[a]),
                              n.bottom - n.height / 2 < e.touches[0].clientY &&
                                i[a] !== i[h] &&
                                s.push(i[a]);
                          }),
                        s.length)
                      )
                        for (let e = s.length - 1; e >= 0; e--) t.unshift(s[e]);
                      l(t);
                    }
                  },
                  onTouchEnd: (t) => {
                    r(o), e.update(o, "changed"), c([]), m([]), a(!1), l([]);
                  },
                  className:
                    _(h) +
                    " " +
                    (e.question.show_correct_answer &&
                    e.question.correct_indexes
                      ? e.question.correct_indexes &&
                        e.question.correct_indexes.length &&
                        e.question.correct_indexes.includes(h)
                        ? "question_correct"
                        : "question_incorrect"
                      : ""),
                },
                Te("div", { dangerouslySetInnerHTML: { __html: p } })
              )
            )
          );
        },
        {
          createElement: He,
          render: Be,
          useState: Re,
          useEffect: Ue,
          Fragment: Je,
        } = wp.element,
        Xe = (e) => {
          e.question.id, e.quiz_id;
          const [t, n] = Re({}),
            [s, a] = Re(!1);
          return (
            Ue(() => {
              let t = e.question;
              if (
                !s &&
                t &&
                t.marked_answer &&
                t.marked_answer.length &&
                "undefined" != t.marked_answer
              ) {
                let e = [];
                t.marked_answer.map((n, s) => {
                  e.push(t.original_options[parseInt(n) - 1]);
                }),
                  (t.options = e),
                  n(t),
                  a(!0);
              }
              n(t);
            }, [e.question]),
            He(
              Je,
              null,
              He("div", {
                className: "question_content",
                dangerouslySetInnerHTML: {
                  __html: t && t.content ? t.content : "",
                },
              }),
              t.options && t.options.length
                ? He(
                    Je,
                    null,
                    He(je, {
                      items: t.options,
                      original_items: t.original_options,
                      update: (s, a) => {
                        if (!t?.expired && "changed" == a) {
                          let a = t;
                          (a.marked_answer = []),
                            s.map((e, t) => {
                              let n = a.original_options.indexOf(e);
                              a.marked_answer.push(n + 1);
                            }),
                            n(a),
                            e.update(a, e.index, "changed");
                        }
                      },
                      question: t,
                    }),
                    t.attempted
                      ? ""
                      : He(
                          "span",
                          {
                            className: "resetq_answer button",
                            onClick: (s) => {
                              let a = { ...t };
                              (a.marked_answer = null),
                                (a.options = a.original_options),
                                n(a),
                                e.update(a, e.index, "changed");
                            },
                          },
                          He("i", { class: "vicon vicon-trash" })
                        )
                  )
                : ""
            )
          );
        },
        {
          createElement: We,
          render: Ye,
          useState: Ve,
          useEffect: Qe,
          Fragment: Ke,
        } = wp.element;
      function Ge(e) {
        if (null == e) return !0;
        if (void 0 === e) return !0;
        if ("number" == typeof e) return !1;
        if (Array.isArray(e) || "string" == typeof e || e instanceof String)
          return 0 === e.length;
        for (var t in e) if (e.hasOwnProperty(t)) return !1;
        return !0;
      }
      const Ze = (e) => {
          const [t, n] = Ve([]),
            [s, a] = Ve(!1),
            [i, r] = Ve([]),
            [o, l] = Ve(""),
            [u, c] = Ve([]),
            [d, m] = Ve(e.matches),
            [p, _] = Ve([]),
            [h, w] = Ve([]),
            [g, f] = Ve([]),
            [v, y] = Ve({}),
            [b, k] = Ve([]),
            [q, x] = Ve([]),
            [N, z] = Ve([]),
            [O, S] = Ve({ x: 0, y: 0 }),
            [E, P] = Ve([]);
          Qe(() => {
            let t = [...e.items];
            e.question &&
              e.question.marked_answer &&
              e.question.marked_answer.length &&
              e.question.marked_answer.map((n) => {
                n &&
                  "NaN" != typeof n &&
                  (t = t.filter(
                    (t) => t != e.question.original_options[n - 1]
                  ));
              }),
              c(t);
            let n = [];
            e.question &&
              e.question.marked_answer &&
              e.question.marked_answer.length &&
              e.question.marked_answer.map((e) => {
                parseFloat(e) - 1 >= 0 ? n.push(e - 1) : n.push(null);
              }),
              z(n),
              e.update(!1, "reset");
          }, [e.items, e.reset]);
          let I = "droppable";
          s && (I += " active");
          const C = (e) => {
            let t = "";
            return s === u[e] && (t = "dragging"), t;
          };
          return We(
            "div",
            { className: "match_playground" },
            We(
              "div",
              { className: "match_options" },
              d && d.length
                ? d.map((n, l) =>
                    We(
                      "div",
                      {
                        key: l,
                        className:
                          "match_option " +
                          (e.question.show_correct_answer &&
                          e.question.correct_indexes
                            ? e.question.correct_indexes &&
                              e.question.correct_indexes.length &&
                              e.question.correct_indexes.includes(l)
                              ? "question_correct"
                              : "question_incorrect"
                            : ""),
                        onDrop: (t) => {
                          ((t, n) => {
                            if (!s) return;
                            if (E.index === n) return;
                            let a = [...u],
                              i = [...N];
                            if (!i[n] && 0 !== i[n]) {
                              a = a.filter((e) => e != s);
                              let t = e.original_items.indexOf(s);
                              d &&
                                d.length &&
                                d.map((e, t) => {
                                  Ge(i[t]) && (i[t] = null);
                                }),
                                Ge(n) || (i[n] = t),
                                z(i),
                                c(a),
                                e.update(i, "changed");
                            }
                          })(0, l);
                        },
                        onDragOver: (e) => {
                          e.preventDefault();
                        },
                        ref: (e) => {
                          ((e, t) => {
                            if (e) {
                              let n = i;
                              n[t] || (n[t] = e), r(n);
                            }
                          })(e, l);
                        },
                      },
                      We("div", { dangerouslySetInnerHTML: { __html: n } }),
                      We(
                        "div",
                        { className: "children" },
                        e.original_items &&
                          null != N[l] &&
                          e.original_items[N[l]]
                          ? We(
                              "div",
                              {
                                key: "droppablediv" + l,
                                draggable: !e.question?.expired,
                                onDragStart: (t) => {
                                  e.original_items[N[l]] &&
                                    (a(e.original_items[N[l]]),
                                    P({ index: l, source: "droppablediv" }));
                                },
                                onDragEnd: () => {
                                  a(!1), P({});
                                },
                                onDragOver: (e) => {
                                  e.preventDefault();
                                },
                                className: C(l),
                                style: q[N[l]],
                                onTouchStart: (n) => {
                                  let s = [...h];
                                  t.map((e, t) => {
                                    let n = e.getBoundingClientRect();
                                    s[t] = n;
                                  }),
                                    w(s);
                                  let r = [...g];
                                  i.map((e, t) => {
                                    let n = e.getBoundingClientRect();
                                    r[t] = n;
                                  }),
                                    f(r),
                                    y(o.getBoundingClientRect()),
                                    e.original_items[N[l]] &&
                                      (a(e.original_items[N[l]]),
                                      P({ index: l, source: "droppablediv" })),
                                    P({});
                                },
                                onTouchMove: (e) => {
                                  if (
                                    e &&
                                    (e.preventDefault(), "touchmove" === e.type)
                                  ) {
                                    let t = [...q];
                                    (t[N[l]] = {
                                      position: "fixed",
                                      top:
                                        Math.floor(e.touches[0].clientY) + "px",
                                      left:
                                        Math.floor(e.touches[0].clientX) + "px",
                                    }),
                                      x(t),
                                      S({
                                        x: e.touches[0].clientX,
                                        y: e.touches[0].clientY,
                                      });
                                  }
                                },
                                onTouchEnd: (t) => {
                                  let n = [...u],
                                    i = [...N];
                                  v.top < O.y &&
                                    v.top + v.height > O.y &&
                                    v.left < O.x &&
                                    v.left + v.width > O.x &&
                                    (n.push(s),
                                    i.map((e, t) => {
                                      e == N[l] && (i[t] = null);
                                    })),
                                    f([]),
                                    y({}),
                                    a(!1),
                                    x([]),
                                    k([]),
                                    c(n),
                                    z(i),
                                    e.update(i, "changed"),
                                    S({ x: 0, y: 0 });
                                },
                              },
                              We("div", {
                                dangerouslySetInnerHTML: {
                                  __html: e.original_items[N[l]],
                                },
                              })
                            )
                          : ""
                      )
                    )
                  )
                : ""
            ),
            We(
              "div",
              {
                className: I,
                onDragOver: (e) => {
                  e.preventDefault();
                },
                onDrop: (t) => {
                  ((t) => {
                    if ("droppablediv" !== E.source) return;
                    if (!s) return;
                    let n = [...u],
                      a = [...N];
                    n.includes(s) || n.push(s),
                      c(n),
                      Ge(E.index) || (a[E.index] = null),
                      z(a),
                      e.update(a, "changed");
                  })();
                },
                ref: (e) => {
                  var t;
                  (t = e) && l(t);
                },
              },
              u && u.length
                ? u.map((s, r) =>
                    We(
                      "div",
                      {
                        key: "draggablediv" + r,
                        onDragStart: (e) => {
                          u[r] && a(u[r]), P({});
                        },
                        onDragEnd: () => {
                          a(!1), P({});
                        },
                        onDragOver: (e) => {
                          e.preventDefault();
                        },
                        ref: (e) => {
                          ((e, s) => {
                            if (e) {
                              let a = t;
                              a[s] || (a[s] = e), n(a);
                            }
                          })(e, r);
                        },
                        draggable: !e.question?.expired,
                        style: b[r],
                        onTouchStart: (e) => {
                          let n = [...h];
                          t.map((e, t) => {
                            let s = e.getBoundingClientRect();
                            n[t] = s;
                          }),
                            w(n);
                          let r = [...g];
                          i.map((e, t) => {
                            let n = e.getBoundingClientRect();
                            r[t] = n;
                          }),
                            f(r),
                            s && a(s),
                            P({});
                        },
                        onTouchMove: (e) => {
                          if ((e.preventDefault(), "touchmove" === e.type)) {
                            let t = [...b];
                            (t[r] = {
                              position: "fixed",
                              top: Math.floor(e.touches[0].clientY) + "px",
                              left: Math.floor(e.touches[0].clientX) + "px",
                            }),
                              k(t),
                              S({
                                x: e.touches[0].clientX,
                                y: e.touches[0].clientY,
                              });
                          }
                        },
                        onTouchEnd: (t) => {
                          k([]);
                          let n = [...u],
                            i = [...N];
                          g.map((t, a) => {
                            if (
                              t.top < O.y &&
                              t.top + t.height > O.y &&
                              t.left < O.x &&
                              t.left + t.width > O.x
                            ) {
                              let t = e.original_items.indexOf(s);
                              t >= 0 &&
                                !i[a] &&
                                0 !== i[a] &&
                                ((i[a] = t), (n = n.filter((e) => e != s)));
                            }
                          }),
                            f([]),
                            a(!1),
                            c(n),
                            z(i),
                            e.update(i, "changed"),
                            S({ x: 0, y: 0 });
                        },
                        className: C(r),
                      },
                      We("div", { dangerouslySetInnerHTML: { __html: s } })
                    )
                  )
                : ""
            )
          );
        },
        {
          createElement: et,
          render: tt,
          useState: nt,
          useEffect: st,
          Fragment: at,
        } = wp.element,
        it = (e) => {
          e.question.id, e.quiz_id;
          const [t, n] = nt({}),
            [s, a] = nt(!1);
          return (
            st(() => {
              n(e.question);
            }, [e.question]),
            et(
              at,
              null,
              et(
                "div",
                { className: "question_content" },
                et("div", {
                  className: "question_statement",
                  dangerouslySetInnerHTML: {
                    __html:
                      t && t.extra_content && t.extra_content.statement
                        ? t.extra_content.statement
                        : "",
                  },
                }),
                t.options &&
                  t.options.length &&
                  t.content.match &&
                  t.content.match.length
                  ? et(Ze, {
                      matches: t.extra_content.match,
                      original_matches: t.extra_content.match,
                      items: t.options,
                      original_items: t.original_options,
                      update: (s, i) => {
                        if (!e?.question?.expired) {
                          if ("changed" == i) {
                            let a = { ...t };
                            (a.marked_answer = []),
                              s.map((e) => {
                                a.marked_answer.push(parseInt(e) + 1);
                              }),
                              n(a),
                              e.update(a, e.index, "changed");
                          }
                          "reset" == i && a(!1);
                        }
                      },
                      reset: s,
                      question: t,
                    })
                  : "",
                et("div", {
                  className: "question_end",
                  dangerouslySetInnerHTML: {
                    __html:
                      t && t.content && t.content.end ? t.content.end : "",
                  },
                })
              ),
              t.attempted
                ? ""
                : et(
                    "span",
                    {
                      className: "resetq_answer button",
                      onClick: (s) => {
                        a(!0);
                        let i = { ...t };
                        (i.marked_answer = null),
                          (i.options = i.original_options),
                          n(i),
                          e.update(i, e.index, "changed");
                      },
                    },
                    et("i", { class: "vicon vicon-trash" })
                  )
            )
          );
        },
        {
          createElement: rt,
          render: ot,
          useState: lt,
          useEffect: ut,
          Fragment: ct,
        } = wp.element,
        dt = (e) => {
          const [t, n] = lt(e.question);
          ut(() => {
            n(e.question);
          }, [e.question]);
          let s = "";
          return (
            t.hasOwnProperty("marked_answer") && t.marked_answer,
            rt(
              ct,
              null,
              rt("div", {
                className: "question_content",
                dangerouslySetInnerHTML: {
                  __html: t && t.content ? t.content : "",
                },
              }),
              t.options && t.options.length
                ? rt(
                    ct,
                    null,
                    ((t) =>
                      t.options.map(function (s, a) {
                        return rt(
                          "div",
                          {
                            className:
                              "question_option radio " +
                              (t.show_correct_answer && t.correct_indexes
                                ? t.correct_indexes &&
                                  t.correct_indexes.length &&
                                  t.correct_indexes.includes(a)
                                  ? "question_correct"
                                  : "question_incorrect"
                                : ""),
                          },
                          rt("input", {
                            type: "radio",
                            name: e.quiz_id + "_" + t.id,
                            value: a,
                            id: e.quiz_id + "_" + t.id + a,
                            checked: parseInt(t.marked_answer) === a,
                            onChange: (s) => {
                              if (e?.question?.expired) return;
                              let a = { ...t };
                              (a.marked_answer = s.target.value),
                                n(a),
                                e.update(a, e.index, "changed");
                            },
                          }),
                          rt("label", {
                            for: e.quiz_id + "_" + t.id + a,
                            dangerouslySetInnerHTML: { __html: s },
                          })
                        );
                      }))(t),
                    t.attempted
                      ? ""
                      : rt(
                          "span",
                          {
                            className: "resetq_answer button",
                            onClick: (t) => {
                              let s = { ...e.question };
                              (s.marked_answer = null), n(s);
                            },
                          },
                          rt("i", { class: "vicon vicon-trash" })
                        )
                  )
                : ""
            )
          );
        },
        {
          createElement: mt,
          render: pt,
          useState: _t,
          useEffect: ht,
          Fragment: wt,
        } = wp.element,
        gt = (e) => {
          const [t, n] = _t({});
          ht(() => {
            n(e.question);
          }, [e.question]);
          let s = "";
          t.hasOwnProperty("marked_answer") && (s = t.marked_answer);
          let a = "";
          return (
            t.hasOwnProperty("usercorrect") &&
              t.show_correct_answer &&
              ((a = "question_incorrect"),
              t.usercorrect > 0 && (a = "question_correct")),
            mt(
              wt,
              null,
              mt("div", {
                className: "question_content",
                dangerouslySetInnerHTML: {
                  __html: t && t.content ? t.content : "",
                },
              }),
              mt(
                "textarea",
                {
                  className: a,
                  type: "text",
                  onChange: (t) => {
                    let s = { ...e.question };
                    (s.marked_answer = t.target.value),
                      n(s),
                      e.update(s, e.index, "changed");
                  },
                  value: s,
                },
                s
              )
            )
          );
        };
      var ft,
        vt,
        yt =
          yt ||
          (function (e, t) {
            var n = {},
              s = (n.lib = {}),
              a = function () {},
              i = (s.Base = {
                extend: function (e) {
                  a.prototype = this;
                  var t = new a();
                  return (
                    e && t.mixIn(e),
                    t.hasOwnProperty("init") ||
                      (t.init = function () {
                        t.$super.init.apply(this, arguments);
                      }),
                    (t.init.prototype = t),
                    (t.$super = this),
                    t
                  );
                },
                create: function () {
                  var e = this.extend();
                  return e.init.apply(e, arguments), e;
                },
                init: function () {},
                mixIn: function (e) {
                  for (var t in e) e.hasOwnProperty(t) && (this[t] = e[t]);
                  e.hasOwnProperty("toString") && (this.toString = e.toString);
                },
                clone: function () {
                  return this.init.prototype.extend(this);
                },
              }),
              r = (s.WordArray = i.extend({
                init: function (e, t) {
                  (e = this.words = e || []),
                    (this.sigBytes = null != t ? t : 4 * e.length);
                },
                toString: function (e) {
                  return (e || l).stringify(this);
                },
                concat: function (e) {
                  var t = this.words,
                    n = e.words,
                    s = this.sigBytes;
                  if (((e = e.sigBytes), this.clamp(), s % 4))
                    for (var a = 0; a < e; a++)
                      t[(s + a) >>> 2] |=
                        ((n[a >>> 2] >>> (24 - (a % 4) * 8)) & 255) <<
                        (24 - ((s + a) % 4) * 8);
                  else if (65535 < n.length)
                    for (a = 0; a < e; a += 4) t[(s + a) >>> 2] = n[a >>> 2];
                  else t.push.apply(t, n);
                  return (this.sigBytes += e), this;
                },
                clamp: function () {
                  var t = this.words,
                    n = this.sigBytes;
                  (t[n >>> 2] &= 4294967295 << (32 - (n % 4) * 8)),
                    (t.length = e.ceil(n / 4));
                },
                clone: function () {
                  var e = i.clone.call(this);
                  return (e.words = this.words.slice(0)), e;
                },
                random: function (t) {
                  for (var n = [], s = 0; s < t; s += 4)
                    n.push((4294967296 * e.random()) | 0);
                  return new r.init(n, t);
                },
              })),
              o = (n.enc = {}),
              l = (o.Hex = {
                stringify: function (e) {
                  var t = e.words;
                  e = e.sigBytes;
                  for (var n = [], s = 0; s < e; s++) {
                    var a = (t[s >>> 2] >>> (24 - (s % 4) * 8)) & 255;
                    n.push((a >>> 4).toString(16)),
                      n.push((15 & a).toString(16));
                  }
                  return n.join("");
                },
                parse: function (e) {
                  for (var t = e.length, n = [], s = 0; s < t; s += 2)
                    n[s >>> 3] |=
                      parseInt(e.substr(s, 2), 16) << (24 - (s % 8) * 4);
                  return new r.init(n, t / 2);
                },
              }),
              u = (o.Latin1 = {
                stringify: function (e) {
                  var t = e.words;
                  e = e.sigBytes;
                  for (var n = [], s = 0; s < e; s++)
                    n.push(
                      String.fromCharCode(
                        (t[s >>> 2] >>> (24 - (s % 4) * 8)) & 255
                      )
                    );
                  return n.join("");
                },
                parse: function (e) {
                  for (var t = e.length, n = [], s = 0; s < t; s++)
                    n[s >>> 2] |= (255 & e.charCodeAt(s)) << (24 - (s % 4) * 8);
                  return new r.init(n, t);
                },
              }),
              c = (o.Utf8 = {
                stringify: function (e) {
                  try {
                    return decodeURIComponent(escape(u.stringify(e)));
                  } catch (e) {
                    throw Error("Malformed UTF-8 data");
                  }
                },
                parse: function (e) {
                  return u.parse(unescape(encodeURIComponent(e)));
                },
              }),
              d = (s.BufferedBlockAlgorithm = i.extend({
                reset: function () {
                  (this._data = new r.init()), (this._nDataBytes = 0);
                },
                _append: function (e) {
                  "string" == typeof e && (e = c.parse(e)),
                    this._data.concat(e),
                    (this._nDataBytes += e.sigBytes);
                },
                _process: function (t) {
                  var n = this._data,
                    s = n.words,
                    a = n.sigBytes,
                    i = this.blockSize,
                    o = a / (4 * i);
                  if (
                    ((t =
                      (o = t
                        ? e.ceil(o)
                        : e.max((0 | o) - this._minBufferSize, 0)) * i),
                    (a = e.min(4 * t, a)),
                    t)
                  ) {
                    for (var l = 0; l < t; l += i) this._doProcessBlock(s, l);
                    (l = s.splice(0, t)), (n.sigBytes -= a);
                  }
                  return new r.init(l, a);
                },
                clone: function () {
                  var e = i.clone.call(this);
                  return (e._data = this._data.clone()), e;
                },
                _minBufferSize: 0,
              }));
            s.Hasher = d.extend({
              cfg: i.extend(),
              init: function (e) {
                (this.cfg = this.cfg.extend(e)), this.reset();
              },
              reset: function () {
                d.reset.call(this), this._doReset();
              },
              update: function (e) {
                return this._append(e), this._process(), this;
              },
              finalize: function (e) {
                return e && this._append(e), this._doFinalize();
              },
              blockSize: 16,
              _createHelper: function (e) {
                return function (t, n) {
                  return new e.init(n).finalize(t);
                };
              },
              _createHmacHelper: function (e) {
                return function (t, n) {
                  return new m.HMAC.init(e, n).finalize(t);
                };
              },
            });
            var m = (n.algo = {});
            return n;
          })(Math);
      (vt = (ft = yt).lib.WordArray),
        (ft.enc.Base64 = {
          stringify: function (e) {
            var t = e.words,
              n = e.sigBytes,
              s = this._map;
            e.clamp(), (e = []);
            for (var a = 0; a < n; a += 3)
              for (
                var i =
                    (((t[a >>> 2] >>> (24 - (a % 4) * 8)) & 255) << 16) |
                    (((t[(a + 1) >>> 2] >>> (24 - ((a + 1) % 4) * 8)) & 255) <<
                      8) |
                    ((t[(a + 2) >>> 2] >>> (24 - ((a + 2) % 4) * 8)) & 255),
                  r = 0;
                4 > r && a + 0.75 * r < n;
                r++
              )
                e.push(s.charAt((i >>> (6 * (3 - r))) & 63));
            if ((t = s.charAt(64))) for (; e.length % 4; ) e.push(t);
            return e.join("");
          },
          parse: function (e) {
            var t = e.length,
              n = this._map;
            (s = n.charAt(64)) && -1 != (s = e.indexOf(s)) && (t = s);
            for (var s = [], a = 0, i = 0; i < t; i++)
              if (i % 4) {
                var r = n.indexOf(e.charAt(i - 1)) << ((i % 4) * 2),
                  o = n.indexOf(e.charAt(i)) >>> (6 - (i % 4) * 2);
                (s[a >>> 2] |= (r | o) << (24 - (a % 4) * 8)), a++;
              }
            return vt.create(s, a);
          },
          _map: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
        }),
        (function (e) {
          function t(e, t, n, s, a, i, r) {
            return (
              (((e = e + ((t & n) | (~t & s)) + a + r) << i) |
                (e >>> (32 - i))) +
              t
            );
          }
          function n(e, t, n, s, a, i, r) {
            return (
              (((e = e + ((t & s) | (n & ~s)) + a + r) << i) |
                (e >>> (32 - i))) +
              t
            );
          }
          function s(e, t, n, s, a, i, r) {
            return (
              (((e = e + (t ^ n ^ s) + a + r) << i) | (e >>> (32 - i))) + t
            );
          }
          function a(e, t, n, s, a, i, r) {
            return (
              (((e = e + (n ^ (t | ~s)) + a + r) << i) | (e >>> (32 - i))) + t
            );
          }
          for (
            var i = yt,
              r = (l = i.lib).WordArray,
              o = l.Hasher,
              l = i.algo,
              u = [],
              c = 0;
            64 > c;
            c++
          )
            u[c] = (4294967296 * e.abs(e.sin(c + 1))) | 0;
          (l = l.MD5 =
            o.extend({
              _doReset: function () {
                this._hash = new r.init([
                  1732584193, 4023233417, 2562383102, 271733878,
                ]);
              },
              _doProcessBlock: function (e, i) {
                for (var r = 0; 16 > r; r++) {
                  var o = e[(l = i + r)];
                  e[l] =
                    (16711935 & ((o << 8) | (o >>> 24))) |
                    (4278255360 & ((o << 24) | (o >>> 8)));
                }
                r = this._hash.words;
                var l = e[i + 0],
                  c = ((o = e[i + 1]), e[i + 2]),
                  d = e[i + 3],
                  m = e[i + 4],
                  p = e[i + 5],
                  _ = e[i + 6],
                  h = e[i + 7],
                  w = e[i + 8],
                  g = e[i + 9],
                  f = e[i + 10],
                  v = e[i + 11],
                  y = e[i + 12],
                  b = e[i + 13],
                  k = e[i + 14],
                  q = e[i + 15],
                  x = t(
                    (x = r[0]),
                    (O = r[1]),
                    (z = r[2]),
                    (N = r[3]),
                    l,
                    7,
                    u[0]
                  ),
                  N = t(N, x, O, z, o, 12, u[1]),
                  z = t(z, N, x, O, c, 17, u[2]),
                  O = t(O, z, N, x, d, 22, u[3]);
                (x = t(x, O, z, N, m, 7, u[4])),
                  (N = t(N, x, O, z, p, 12, u[5])),
                  (z = t(z, N, x, O, _, 17, u[6])),
                  (O = t(O, z, N, x, h, 22, u[7])),
                  (x = t(x, O, z, N, w, 7, u[8])),
                  (N = t(N, x, O, z, g, 12, u[9])),
                  (z = t(z, N, x, O, f, 17, u[10])),
                  (O = t(O, z, N, x, v, 22, u[11])),
                  (x = t(x, O, z, N, y, 7, u[12])),
                  (N = t(N, x, O, z, b, 12, u[13])),
                  (z = t(z, N, x, O, k, 17, u[14])),
                  (x = n(
                    x,
                    (O = t(O, z, N, x, q, 22, u[15])),
                    z,
                    N,
                    o,
                    5,
                    u[16]
                  )),
                  (N = n(N, x, O, z, _, 9, u[17])),
                  (z = n(z, N, x, O, v, 14, u[18])),
                  (O = n(O, z, N, x, l, 20, u[19])),
                  (x = n(x, O, z, N, p, 5, u[20])),
                  (N = n(N, x, O, z, f, 9, u[21])),
                  (z = n(z, N, x, O, q, 14, u[22])),
                  (O = n(O, z, N, x, m, 20, u[23])),
                  (x = n(x, O, z, N, g, 5, u[24])),
                  (N = n(N, x, O, z, k, 9, u[25])),
                  (z = n(z, N, x, O, d, 14, u[26])),
                  (O = n(O, z, N, x, w, 20, u[27])),
                  (x = n(x, O, z, N, b, 5, u[28])),
                  (N = n(N, x, O, z, c, 9, u[29])),
                  (z = n(z, N, x, O, h, 14, u[30])),
                  (x = s(
                    x,
                    (O = n(O, z, N, x, y, 20, u[31])),
                    z,
                    N,
                    p,
                    4,
                    u[32]
                  )),
                  (N = s(N, x, O, z, w, 11, u[33])),
                  (z = s(z, N, x, O, v, 16, u[34])),
                  (O = s(O, z, N, x, k, 23, u[35])),
                  (x = s(x, O, z, N, o, 4, u[36])),
                  (N = s(N, x, O, z, m, 11, u[37])),
                  (z = s(z, N, x, O, h, 16, u[38])),
                  (O = s(O, z, N, x, f, 23, u[39])),
                  (x = s(x, O, z, N, b, 4, u[40])),
                  (N = s(N, x, O, z, l, 11, u[41])),
                  (z = s(z, N, x, O, d, 16, u[42])),
                  (O = s(O, z, N, x, _, 23, u[43])),
                  (x = s(x, O, z, N, g, 4, u[44])),
                  (N = s(N, x, O, z, y, 11, u[45])),
                  (z = s(z, N, x, O, q, 16, u[46])),
                  (x = a(
                    x,
                    (O = s(O, z, N, x, c, 23, u[47])),
                    z,
                    N,
                    l,
                    6,
                    u[48]
                  )),
                  (N = a(N, x, O, z, h, 10, u[49])),
                  (z = a(z, N, x, O, k, 15, u[50])),
                  (O = a(O, z, N, x, p, 21, u[51])),
                  (x = a(x, O, z, N, y, 6, u[52])),
                  (N = a(N, x, O, z, d, 10, u[53])),
                  (z = a(z, N, x, O, f, 15, u[54])),
                  (O = a(O, z, N, x, o, 21, u[55])),
                  (x = a(x, O, z, N, w, 6, u[56])),
                  (N = a(N, x, O, z, q, 10, u[57])),
                  (z = a(z, N, x, O, _, 15, u[58])),
                  (O = a(O, z, N, x, b, 21, u[59])),
                  (x = a(x, O, z, N, m, 6, u[60])),
                  (N = a(N, x, O, z, v, 10, u[61])),
                  (z = a(z, N, x, O, c, 15, u[62])),
                  (O = a(O, z, N, x, g, 21, u[63])),
                  (r[0] = (r[0] + x) | 0),
                  (r[1] = (r[1] + O) | 0),
                  (r[2] = (r[2] + z) | 0),
                  (r[3] = (r[3] + N) | 0);
              },
              _doFinalize: function () {
                var t = this._data,
                  n = t.words,
                  s = 8 * this._nDataBytes,
                  a = 8 * t.sigBytes;
                n[a >>> 5] |= 128 << (24 - (a % 32));
                var i = e.floor(s / 4294967296);
                for (
                  n[15 + (((a + 64) >>> 9) << 4)] =
                    (16711935 & ((i << 8) | (i >>> 24))) |
                    (4278255360 & ((i << 24) | (i >>> 8))),
                    n[14 + (((a + 64) >>> 9) << 4)] =
                      (16711935 & ((s << 8) | (s >>> 24))) |
                      (4278255360 & ((s << 24) | (s >>> 8))),
                    t.sigBytes = 4 * (n.length + 1),
                    this._process(),
                    n = (t = this._hash).words,
                    s = 0;
                  4 > s;
                  s++
                )
                  (a = n[s]),
                    (n[s] =
                      (16711935 & ((a << 8) | (a >>> 24))) |
                      (4278255360 & ((a << 24) | (a >>> 8))));
                return t;
              },
              clone: function () {
                var e = o.clone.call(this);
                return (e._hash = this._hash.clone()), e;
              },
            })),
            (i.MD5 = o._createHelper(l)),
            (i.HmacMD5 = o._createHmacHelper(l));
        })(Math),
        (function () {
          var e,
            t = yt,
            n = (e = t.lib).Base,
            s = e.WordArray,
            a = ((e = t.algo).EvpKDF = n.extend({
              cfg: n.extend({ keySize: 4, hasher: e.MD5, iterations: 1 }),
              init: function (e) {
                this.cfg = this.cfg.extend(e);
              },
              compute: function (e, t) {
                for (
                  var n = (o = this.cfg).hasher.create(),
                    a = s.create(),
                    i = a.words,
                    r = o.keySize,
                    o = o.iterations;
                  i.length < r;

                ) {
                  l && n.update(l);
                  var l = n.update(e).finalize(t);
                  n.reset();
                  for (var u = 1; u < o; u++) (l = n.finalize(l)), n.reset();
                  a.concat(l);
                }
                return (a.sigBytes = 4 * r), a;
              },
            }));
          t.EvpKDF = function (e, t, n) {
            return a.create(n).compute(e, t);
          };
        })(),
        yt.lib.Cipher ||
          (function (e) {
            var t = (p = yt).lib,
              n = t.Base,
              s = t.WordArray,
              a = t.BufferedBlockAlgorithm,
              i = p.enc.Base64,
              r = p.algo.EvpKDF,
              o = (t.Cipher = a.extend({
                cfg: n.extend(),
                createEncryptor: function (e, t) {
                  return this.create(this._ENC_XFORM_MODE, e, t);
                },
                createDecryptor: function (e, t) {
                  return this.create(this._DEC_XFORM_MODE, e, t);
                },
                init: function (e, t, n) {
                  (this.cfg = this.cfg.extend(n)),
                    (this._xformMode = e),
                    (this._key = t),
                    this.reset();
                },
                reset: function () {
                  a.reset.call(this), this._doReset();
                },
                process: function (e) {
                  return this._append(e), this._process();
                },
                finalize: function (e) {
                  return e && this._append(e), this._doFinalize();
                },
                keySize: 4,
                ivSize: 4,
                _ENC_XFORM_MODE: 1,
                _DEC_XFORM_MODE: 2,
                _createHelper: function (e) {
                  return {
                    encrypt: function (t, n, s) {
                      return ("string" == typeof n ? _ : m).encrypt(e, t, n, s);
                    },
                    decrypt: function (t, n, s) {
                      return ("string" == typeof n ? _ : m).decrypt(e, t, n, s);
                    },
                  };
                },
              }));
            t.StreamCipher = o.extend({
              _doFinalize: function () {
                return this._process(!0);
              },
              blockSize: 1,
            });
            var l = (p.mode = {}),
              u = function (e, t, n) {
                var s = this._iv;
                s ? (this._iv = void 0) : (s = this._prevBlock);
                for (var a = 0; a < n; a++) e[t + a] ^= s[a];
              },
              c = (t.BlockCipherMode = n.extend({
                createEncryptor: function (e, t) {
                  return this.Encryptor.create(e, t);
                },
                createDecryptor: function (e, t) {
                  return this.Decryptor.create(e, t);
                },
                init: function (e, t) {
                  (this._cipher = e), (this._iv = t);
                },
              })).extend();
            (c.Encryptor = c.extend({
              processBlock: function (e, t) {
                var n = this._cipher,
                  s = n.blockSize;
                u.call(this, e, t, s),
                  n.encryptBlock(e, t),
                  (this._prevBlock = e.slice(t, t + s));
              },
            })),
              (c.Decryptor = c.extend({
                processBlock: function (e, t) {
                  var n = this._cipher,
                    s = n.blockSize,
                    a = e.slice(t, t + s);
                  n.decryptBlock(e, t),
                    u.call(this, e, t, s),
                    (this._prevBlock = a);
                },
              })),
              (l = l.CBC = c),
              (c = (p.pad = {}).Pkcs7 =
                {
                  pad: function (e, t) {
                    for (
                      var n,
                        a =
                          ((n = (n = 4 * t) - (e.sigBytes % n)) << 24) |
                          (n << 16) |
                          (n << 8) |
                          n,
                        i = [],
                        r = 0;
                      r < n;
                      r += 4
                    )
                      i.push(a);
                    (n = s.create(i, n)), e.concat(n);
                  },
                  unpad: function (e) {
                    e.sigBytes -= 255 & e.words[(e.sigBytes - 1) >>> 2];
                  },
                }),
              (t.BlockCipher = o.extend({
                cfg: o.cfg.extend({ mode: l, padding: c }),
                reset: function () {
                  o.reset.call(this);
                  var e = (t = this.cfg).iv,
                    t = t.mode;
                  if (this._xformMode == this._ENC_XFORM_MODE)
                    var n = t.createEncryptor;
                  else (n = t.createDecryptor), (this._minBufferSize = 1);
                  this._mode = n.call(t, this, e && e.words);
                },
                _doProcessBlock: function (e, t) {
                  this._mode.processBlock(e, t);
                },
                _doFinalize: function () {
                  var e = this.cfg.padding;
                  if (this._xformMode == this._ENC_XFORM_MODE) {
                    e.pad(this._data, this.blockSize);
                    var t = this._process(!0);
                  } else (t = this._process(!0)), e.unpad(t);
                  return t;
                },
                blockSize: 4,
              }));
            var d = (t.CipherParams = n.extend({
                init: function (e) {
                  this.mixIn(e);
                },
                toString: function (e) {
                  return (e || this.formatter).stringify(this);
                },
              })),
              m =
                ((l = (p.format = {}).OpenSSL =
                  {
                    stringify: function (e) {
                      var t = e.ciphertext;
                      return (
                        (e = e.salt)
                          ? s
                              .create([1398893684, 1701076831])
                              .concat(e)
                              .concat(t)
                          : t
                      ).toString(i);
                    },
                    parse: function (e) {
                      var t = (e = i.parse(e)).words;
                      if (1398893684 == t[0] && 1701076831 == t[1]) {
                        var n = s.create(t.slice(2, 4));
                        t.splice(0, 4), (e.sigBytes -= 16);
                      }
                      return d.create({ ciphertext: e, salt: n });
                    },
                  }),
                (t.SerializableCipher = n.extend({
                  cfg: n.extend({ format: l }),
                  encrypt: function (e, t, n, s) {
                    s = this.cfg.extend(s);
                    var a = e.createEncryptor(n, s);
                    return (
                      (t = a.finalize(t)),
                      (a = a.cfg),
                      d.create({
                        ciphertext: t,
                        key: n,
                        iv: a.iv,
                        algorithm: e,
                        mode: a.mode,
                        padding: a.padding,
                        blockSize: e.blockSize,
                        formatter: s.format,
                      })
                    );
                  },
                  decrypt: function (e, t, n, s) {
                    return (
                      (s = this.cfg.extend(s)),
                      (t = this._parse(t, s.format)),
                      e.createDecryptor(n, s).finalize(t.ciphertext)
                    );
                  },
                  _parse: function (e, t) {
                    return "string" == typeof e ? t.parse(e, this) : e;
                  },
                }))),
              p = ((p.kdf = {}).OpenSSL = {
                execute: function (e, t, n, a) {
                  return (
                    a || (a = s.random(8)),
                    (e = r.create({ keySize: t + n }).compute(e, a)),
                    (n = s.create(e.words.slice(t), 4 * n)),
                    (e.sigBytes = 4 * t),
                    d.create({ key: e, iv: n, salt: a })
                  );
                },
              }),
              _ = (t.PasswordBasedCipher = m.extend({
                cfg: m.cfg.extend({ kdf: p }),
                encrypt: function (e, t, n, s) {
                  return (
                    (n = (s = this.cfg.extend(s)).kdf.execute(
                      n,
                      e.keySize,
                      e.ivSize
                    )),
                    (s.iv = n.iv),
                    (e = m.encrypt.call(this, e, t, n.key, s)).mixIn(n),
                    e
                  );
                },
                decrypt: function (e, t, n, s) {
                  return (
                    (s = this.cfg.extend(s)),
                    (t = this._parse(t, s.format)),
                    (n = s.kdf.execute(n, e.keySize, e.ivSize, t.salt)),
                    (s.iv = n.iv),
                    m.decrypt.call(this, e, t, n.key, s)
                  );
                },
              }));
          })(),
        (function () {
          for (
            var e = yt,
              t = e.lib.BlockCipher,
              n = e.algo,
              s = [],
              a = [],
              i = [],
              r = [],
              o = [],
              l = [],
              u = [],
              c = [],
              d = [],
              m = [],
              p = [],
              _ = 0;
            256 > _;
            _++
          )
            p[_] = 128 > _ ? _ << 1 : (_ << 1) ^ 283;
          var h = 0,
            w = 0;
          for (_ = 0; 256 > _; _++) {
            var g =
              ((g = w ^ (w << 1) ^ (w << 2) ^ (w << 3) ^ (w << 4)) >>> 8) ^
              (255 & g) ^
              99;
            (s[h] = g), (a[g] = h);
            var f = p[h],
              v = p[f],
              y = p[v],
              b = (257 * p[g]) ^ (16843008 * g);
            (i[h] = (b << 24) | (b >>> 8)),
              (r[h] = (b << 16) | (b >>> 16)),
              (o[h] = (b << 8) | (b >>> 24)),
              (l[h] = b),
              (b = (16843009 * y) ^ (65537 * v) ^ (257 * f) ^ (16843008 * h)),
              (u[g] = (b << 24) | (b >>> 8)),
              (c[g] = (b << 16) | (b >>> 16)),
              (d[g] = (b << 8) | (b >>> 24)),
              (m[g] = b),
              h ? ((h = f ^ p[p[p[y ^ f]]]), (w ^= p[p[w]])) : (h = w = 1);
          }
          var k = [0, 1, 2, 4, 8, 16, 32, 64, 128, 27, 54];
          (n = n.AES =
            t.extend({
              _doReset: function () {
                for (
                  var e = (n = this._key).words,
                    t = n.sigBytes / 4,
                    n = 4 * ((this._nRounds = t + 6) + 1),
                    a = (this._keySchedule = []),
                    i = 0;
                  i < n;
                  i++
                )
                  if (i < t) a[i] = e[i];
                  else {
                    var r = a[i - 1];
                    i % t
                      ? 6 < t &&
                        4 == i % t &&
                        (r =
                          (s[r >>> 24] << 24) |
                          (s[(r >>> 16) & 255] << 16) |
                          (s[(r >>> 8) & 255] << 8) |
                          s[255 & r])
                      : ((r =
                          (s[(r = (r << 8) | (r >>> 24)) >>> 24] << 24) |
                          (s[(r >>> 16) & 255] << 16) |
                          (s[(r >>> 8) & 255] << 8) |
                          s[255 & r]),
                        (r ^= k[(i / t) | 0] << 24)),
                      (a[i] = a[i - t] ^ r);
                  }
                for (e = this._invKeySchedule = [], t = 0; t < n; t++)
                  (i = n - t),
                    (r = t % 4 ? a[i] : a[i - 4]),
                    (e[t] =
                      4 > t || 4 >= i
                        ? r
                        : u[s[r >>> 24]] ^
                          c[s[(r >>> 16) & 255]] ^
                          d[s[(r >>> 8) & 255]] ^
                          m[s[255 & r]]);
              },
              encryptBlock: function (e, t) {
                this._doCryptBlock(e, t, this._keySchedule, i, r, o, l, s);
              },
              decryptBlock: function (e, t) {
                var n = e[t + 1];
                (e[t + 1] = e[t + 3]),
                  (e[t + 3] = n),
                  this._doCryptBlock(e, t, this._invKeySchedule, u, c, d, m, a),
                  (n = e[t + 1]),
                  (e[t + 1] = e[t + 3]),
                  (e[t + 3] = n);
              },
              _doCryptBlock: function (e, t, n, s, a, i, r, o) {
                for (
                  var l = this._nRounds,
                    u = e[t] ^ n[0],
                    c = e[t + 1] ^ n[1],
                    d = e[t + 2] ^ n[2],
                    m = e[t + 3] ^ n[3],
                    p = 4,
                    _ = 1;
                  _ < l;
                  _++
                ) {
                  var h =
                      s[u >>> 24] ^
                      a[(c >>> 16) & 255] ^
                      i[(d >>> 8) & 255] ^
                      r[255 & m] ^
                      n[p++],
                    w =
                      s[c >>> 24] ^
                      a[(d >>> 16) & 255] ^
                      i[(m >>> 8) & 255] ^
                      r[255 & u] ^
                      n[p++],
                    g =
                      s[d >>> 24] ^
                      a[(m >>> 16) & 255] ^
                      i[(u >>> 8) & 255] ^
                      r[255 & c] ^
                      n[p++];
                  (m =
                    s[m >>> 24] ^
                    a[(u >>> 16) & 255] ^
                    i[(c >>> 8) & 255] ^
                    r[255 & d] ^
                    n[p++]),
                    (u = h),
                    (c = w),
                    (d = g);
                }
                (h =
                  ((o[u >>> 24] << 24) |
                    (o[(c >>> 16) & 255] << 16) |
                    (o[(d >>> 8) & 255] << 8) |
                    o[255 & m]) ^
                  n[p++]),
                  (w =
                    ((o[c >>> 24] << 24) |
                      (o[(d >>> 16) & 255] << 16) |
                      (o[(m >>> 8) & 255] << 8) |
                      o[255 & u]) ^
                    n[p++]),
                  (g =
                    ((o[d >>> 24] << 24) |
                      (o[(m >>> 16) & 255] << 16) |
                      (o[(u >>> 8) & 255] << 8) |
                      o[255 & c]) ^
                    n[p++]),
                  (m =
                    ((o[m >>> 24] << 24) |
                      (o[(u >>> 16) & 255] << 16) |
                      (o[(c >>> 8) & 255] << 8) |
                      o[255 & d]) ^
                    n[p++]),
                  (e[t] = h),
                  (e[t + 1] = w),
                  (e[t + 2] = g),
                  (e[t + 3] = m);
              },
              keySize: 8,
            })),
            (e.AES = t._createHelper(n));
        })();
      const bt = yt,
        kt = {
          stringify: function (e) {
            var t = { ct: e.ciphertext.toString(bt.enc.Base64) };
            return (
              e.iv && (t.iv = e.iv.toString()),
              e.salt && (t.s = e.salt.toString()),
              JSON.stringify(t).replace(/\s/g, "")
            );
          },
          parse: function (e) {
            var t = JSON.parse(e),
              n = bt.lib.CipherParams.create({
                ciphertext: bt.enc.Base64.parse(t.ct),
              });
            return (
              t.iv && (n.iv = bt.enc.Hex.parse(t.iv)),
              t.s && (n.salt = bt.enc.Hex.parse(t.s)),
              n
            );
          },
        },
        qt = (e) => {
          let t = "";
          if (!e.type) return "";
          switch (e.type) {
            case "truefalse":
              t = e.correct
                ? window.wplms_course_data.translations.true
                : window.wplms_course_data.translations.false;
              break;
            case "single":
            case "survey":
              t = e.options[parseInt(e.correct) - 1];
              break;
            case "multiple":
              if (((t = ""), (n = e.correct.split(",")).length))
                for (let s = 0; s < n.length; s++)
                  t +=
                    e.options[parseInt(n[s]) - 1] +
                    (s + 1 < n.length ? " , " : "");
              break;
            case "sort":
            case "match":
              if (((t = ""), (n = e.correct.split(",")).length))
                for (let s = 0; s < n.length; s++)
                  t +=
                    e.original_options[parseInt(n[s]) - 1] +
                    (s + 1 < n.length ? " , " : "");
              break;
            case "select":
              if (((t = ""), (n = e.correct.split("|")).length))
                for (let s = 0; s < n.length; s++)
                  t +=
                    e.options[parseInt(n[s]) - 1] +
                    (s + 1 < n.length ? " , " : "");
              break;
            case "fillblank":
            case "text":
            case "largetext":
            case "smalltext":
              var n;
              if (((t = ""), (n = e.correct.split("|")).length))
                for (let e = 0; e < n.length; e++)
                  t += n[e] + (e + 1 < n.length ? " , " : "");
          }
          return t;
        };
      function xt(e) {
        if (null == e) return !0;
        if (void 0 === e) return !0;
        if ("number" == typeof e) return !1;
        if (Array.isArray(e) || "string" == typeof e || e instanceof String)
          return 0 === e.length;
        for (var t in e) if (e.hasOwnProperty(t)) return !1;
        return !0;
      }
      const Nt = (e, t = null, n = null, s = null, a = !0) => {
          s && (s = parseFloat(s)), n || (s = null);
          let i = 0,
            r = [],
            o = 0;
          e.user_marks = 0;
          let l = 0,
            u = null;
          xt(e.correct) ||
            (u = JSON.parse(
              bt.AES.decrypt(e.correct, e.key, { format: kt }).toString(
                bt.enc.Utf8
              )
            )),
            (e.correct = u);
          let c = null;
          switch (
            (e.hasOwnProperty("marked_answer") && (c = e.marked_answer), e.type)
          ) {
            case "truefalse":
              (e.marked = c),
                (e.correct = parseInt(u)),
                c == u
                  ? ((e.user_marks = e.marks), (i = 1))
                  : (e.user_marks = 0),
                r.push(u);
              break;
            case "single":
              (e.marked = c),
                c == u - 1
                  ? ((e.user_marks = e.marks), (i = 1))
                  : (e.user_marks = 0),
                r.push(u - 1);
              break;
            case "multiple":
              xt(c) && (c = []);
              var d = c;
              e.marked = c.join(",").slice();
              var m = u.split(",");
              if (((r = m), t)) {
                if (d.length)
                  for (let e = 0; e < d.length; e++) {
                    let t = d[e] + 1;
                    (t = t.toString()), -1 !== m.indexOf(t) ? o++ : l++;
                  }
                (i = o / m.length),
                  (e.user_marks = Math.round(e.marks * i * 100) / 100);
              } else if (d.length == m.length)
                for (let t = 0; t < d.length; t++) {
                  (e.user_marks = e.marks), (i = 1);
                  let n = d[t] + 1;
                  if (((n = n.toString()), -1 == m.indexOf(n))) {
                    (e.user_marks = 0), (i = 0);
                    break;
                  }
                }
              break;
            case "match":
            case "sort":
              xt(c) && (c = []), (e.marked = c.join(",").slice());
              let n = c,
                s = u.split(","),
                a = 0;
              if (n && n.length) {
                for (let t = 0; t < n.length; t++) {
                  (e.user_marks = e.marks), (i = 1);
                  let u = "";
                  xt(n[t]) || (u = n[t].toString()),
                    s[t] != u
                      ? (i && ((e.user_marks = 0), (i = 0), (a = 1)), l++)
                      : (o++, r.push(t));
                }
                t
                  ? ((i = o / s.length),
                    (e.user_marks = Math.round(e.marks * i * 100) / 100))
                  : a && ((e.user_marks = 0), (i = 0));
              }
              break;
            case "fillblank":
              xt(c) && (c = []),
                c.map((e, t) => {
                  (c[t] = e.toLowerCase()),
                    window.wplms_course_data &&
                      window.wplms_course_data.hasOwnProperty(
                        "trim_question_answer"
                      ) &&
                      window.wplms_course_data.trim_question_answer &&
                      c[t].trim();
                }),
                (e.marked = c.join("|").slice()),
                (u = u.toLowerCase());
              let p = u.split("|");
              if (((e.user_marks = 0), c.length)) {
                (e.user_marks = e.marks), (i = 1);
                for (let t = 0; t < c.length; t++) {
                  let n = "";
                  xt(c[t]) || (n = c[t].toString());
                  let s = [];
                  xt(p[t]) || Array.isArray(p[t]) || (s = p[t].split(",")),
                    -1 == s.indexOf(n)
                      ? (i && ((e.user_marks = 0), (i = 0)), l++)
                      : (o++, r.push(t));
                }
                t
                  ? ((i = o / p.length),
                    (e.user_marks = Math.round(e.marks * i * 100) / 100))
                  : c.length !== p.length && ((e.user_marks = 0), (i = 0));
              }
              break;
            case "select":
              xt(c) && (c = []), (e.marked = c.join("|").slice());
              let _ = u.split("|");
              if (((e.user_marks = 0), c && c.length)) {
                (e.user_marks = e.marks), (i = 1);
                for (let t = 0; t < c.length; t++) {
                  let n = "";
                  (n = (parseInt(c[t]) + 1).toString()),
                    n != _[t]
                      ? (i && ((e.user_marks = 0), (i = 0)), l++)
                      : (o++, r.push(t));
                }
                t
                  ? ((i = o / _.length),
                    (e.user_marks = Math.round(e.marks * i * 100) / 100))
                  : c.length !== _.length && ((e.user_marks = 0), (i = 0));
              }
              break;
            case "smalltext":
            case "largetext":
              (e.marked = c),
                c && u && c.toLowerCase() == u.toLowerCase()
                  ? ((e.user_marks = e.marks), (i = 1))
                  : (e.user_marks = 0);
          }
          if (
            (!xt(c) &&
              s &&
              (t && l > 0
                ? (e.user_marks = e.user_marks - l * s)
                : i || (e.user_marks = e.user_marks - s)),
            e.auto || a || ((e.user_marks = 0), (e.show_correct_answer = 0)),
            r && r.length)
          )
            for (var p = r.length - 1; p >= 0; p--)
              "multiple" == e.type
                ? (r[p] = parseInt(r[p] - 1))
                : (r[p] = parseInt(r[p]));
          return (
            (e.correct_indexes = r),
            e.auto && ((e.usercorrect = i), (e.attempted = !0)),
            (e.marked = ((e) => {
              let t = "";
              if (!e.type) return t;
              if (!e.marked || "undefined" == e.marked) return t;
              switch (e.type) {
                case "truefalse":
                case "single":
                case "survey":
                  t = e.options[parseInt(e.marked)];
                  break;
                case "multiple":
                  if (((t = ""), (n = e.marked.split(",")).length))
                    for (let s = 0; s < n.length; s++)
                      t +=
                        e.options[parseInt(n[s])] +
                        (s + 1 < n.length ? " , " : "");
                  break;
                case "sort":
                case "match":
                  if ((n = e.marked.split(",")).length)
                    for (let s = 0; s < n.length; s++)
                      ("undefined" !== e.original_options[parseInt(n[s]) - 1] &&
                        null != e.original_options[parseInt(n[s]) - 1] &&
                        "" != e.original_options[parseInt(n[s]) - 1]) ||
                        (e.original_options[parseInt(n[s]) - 1] = "____"),
                        (t +=
                          e.original_options[parseInt(n[s]) - 1] +
                          (s + 1 < n.length ? " , " : ""));
                  break;
                case "select":
                  if (((t = ""), (n = e.marked.split("|")).length))
                    for (let s = 0; s < n.length; s++)
                      t +=
                        e.options[parseInt(n[s])] +
                        (s + 1 < n.length ? " , " : "");
                  break;
                case "fillblank":
                case "text":
                  var n;
                  if (((t = ""), (n = e.marked.split("|")).length))
                    for (let e = 0; e < n.length; e++)
                      t += n[e] + (e + 1 < n.length ? " , " : "");
                  break;
                case "largetext":
                case "smalltext":
                  t = e.marked;
              }
              return t;
            })(e)),
            (e.correct = qt(e)),
            e
          );
        },
        {
          createElement: zt,
          render: Ot,
          useState: St,
          useEffect: Et,
          Fragment: Pt,
          RawHTML: It,
        } = wp.element,
        Ct = (e) => {
          const [t, n] = St({}),
            [s, a] = St(!1);
          Et(() => {
            n(e.question),
              setTimeout(() => {
                a(!0);
              }, 200);
          }, []);
          let i = "incorrect",
            r = "checked_answer incorrect";
          return (
            t.hasOwnProperty("user_marks") &&
              t.user_marks &&
              parseFloat(t.user_marks) > 0 &&
              ((i = "correct"), (r = "checked_answer correct")),
            zt(
              Pt,
              null,
              t.show_correct_answer && void 0 !== t.correct && t.correct.length
                ? zt(
                    "div",
                    { className: r },
                    zt(
                      "strong",
                      null,
                      window.wplms_course_data.translations.correct_answer,
                      zt(It, null, t.correct)
                    )
                  )
                : "",
              zt(
                "div",
                {
                  className: s ? "question_wrapper loaded" : "question_wrapper",
                },
                zt(
                  "div",
                  { className: "result" },
                  zt(
                    "div",
                    { className: i },
                    zt("span", null),
                    zt("strong", null, t.user_marks)
                  )
                )
              )
            )
          );
        },
        {
          createElement: Mt,
          render: Lt,
          useState: Tt,
          useEffect: At,
          Fragment: Dt,
        } = wp.element,
        $t = (e) => {
          let t = "",
            n = "";
          return (
            At(() => {}, [e.question]),
            e.question.hasOwnProperty("show_hint") && e.question.show_hint
              ? ((n = "question_hint_content message show"),
                (t = "question_hint show"))
              : ((e.question.show_hint = 0),
                (n = "question_hint_content message"),
                (t = "question_hint")),
            Mt(
              Dt,
              null,
              e.question.hint
                ? Mt("span", {
                    className: t,
                    onClick: (t) => {
                      (e.question.show_hint = !e.question.show_hint),
                        e.update({ ...e.question }, e.index, "changed");
                    },
                  })
                : "",
              e.question.hint
                ? Mt("span", {
                    className: n,
                    dangerouslySetInnerHTML: { __html: e.question.hint },
                  })
                : ""
            )
          );
        },
        {
          createElement: Ft,
          render: jt,
          useState: Ht,
          useEffect: Bt,
          Fragment: Rt,
        } = wp.element,
        Ut = (e) => {
          const [t, n] = Ht({}),
            [s, a] = Ht([]);
          Bt(() => {
            n(e.quiz), a(e.currentQuestions);
          }, [e.quiz, e.currentQuestions]);
          let i = [];
          if (
            (t.hasOwnProperty("meta") &&
              t.meta.hasOwnProperty("questions") &&
              t.meta.questions &&
              t.meta.questions.length &&
              (i = t.meta.questions),
            i.length)
          )
            if (null !== e.filter)
              switch (e.filter) {
                case "wrong":
                  i = i.filter(
                    (e) =>
                      !e.hasOwnProperty("user_marks") ||
                      !e.user_marks ||
                      parseFloat(e.user_marks) <= 0
                  );
                  break;
                case "correct":
                  i = i.filter(
                    (e) =>
                      e.hasOwnProperty("user_marks") &&
                      e.user_marks &&
                      parseFloat(e.user_marks) > 0
                  );
                  break;
                case "bookmarked":
                  i = i.filter((t) => e.bookMarked.indexOf(t.id) > -1);
              }
            else i = t.meta.questions;
          return Ft(
            "div",
            { className: "" },
            Ft(
              "div",
              {
                class:
                  t &&
                  t.meta &&
                  t.meta.questions &&
                  t.meta.questions.length >= 10
                    ? "timeline_wrapper question_numbers"
                    : "timeline_wrapper",
              },
              Ft(
                "ul",
                null,
                t && t.meta && t.meta.questions && t.meta.questions.length
                  ? i.map((n, i) => {
                      let r = "";
                      return (
                        e.bookMarked.indexOf(n.id) > -1 && (r += " bookmarked"),
                        (("undefined" != n.marked_answer &&
                          null != n.marked_answer) ||
                          (Array.isArray(n.marked_answer) &&
                            n.marked_answer.length)) &&
                          ((r += " done"),
                          n.hasOwnProperty("attempted") &&
                            n.attempted &&
                            (n.hasOwnProperty("user_marks") &&
                            n.user_marks &&
                            parseFloat(n.user_marks) > 0
                              ? (r += " correct")
                              : (r += " incorrect"))),
                        -1 !== s.indexOf(i) && (r += " active"),
                        Ft(
                          "li",
                          {
                            className: r,
                            "data-number":
                              window.wplms_course_data.translations
                                .question_prefix +
                              (i + 1),
                          },
                          Ft(
                            "span",
                            {
                              onClick: (n) => {
                                ((n, i, r) => {
                                  n.preventDefault();
                                  let o = [...s],
                                    l = [];
                                  if (
                                    t.question_number &&
                                    "undefined" != t.question_number &&
                                    t.question_number > 0
                                  ) {
                                    if (-1 !== o.indexOf(r)) return;
                                    let e = Math.ceil(
                                        (r + 1) / t.question_number
                                      ),
                                      n =
                                        e * t.question_number -
                                        t.question_number,
                                      s = e * t.question_number;
                                    for (let e = n; e < s; e++) l.push(e);
                                    a(l);
                                  }
                                  e.update(l, "show");
                                })(n, 0, i);
                              },
                            },
                            n.marks
                          )
                        )
                      );
                    })
                  : "",
                t && t.meta && t.meta.questions && t.meta.questions.length
                  ? Ft(
                      "span",
                      { className: "hide_questions", onClick: e.hideQuestions },
                      Ft("span", { class: "vicon vicon-angle-double-left" }),
                      Ft(
                        "span",
                        null,
                        window.wplms_course_data.translations.hide_questions
                      )
                    )
                  : ""
              )
            )
          );
        },
        {
          createElement: Jt,
          render: Xt,
          useState: Wt,
          useEffect: Yt,
          Fragment: Vt,
        } = wp.element,
        {
          createElement: Qt,
          render: Kt,
          useState: Gt,
          useEffect: Zt,
          Fragment: en,
        } = wp.element,
        tn = (e) => {
          const [t, n] = Gt({}),
            [s, a] = Gt([]),
            [i, r] = Gt(1);
          Zt(() => {
            if ((n(e.quiz), a(e.currentQuestions), e.currentQuestions.length)) {
              let t = Math.ceil(
                (e.currentQuestions[0] + 1) / e.quiz.question_number
              );
              r(t);
            }
            const t = document.createElement("script");
            (t.src =
              "https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.0/MathJax.js"),
              (t.async = !0),
              (t.onload = () => {
                document.dispatchEvent(new Event("VibeBP_Editor_Content"));
              }),
              document.body.appendChild(t);
          }, [e.quiz, e.currentQuestions]),
            Zt(() => {
              n(e.quiz), o(null, 1);
            }, [e.filter]),
            Zt(() => {
              "bookmarked" == e.filter &&
                e.questions.length &&
                s.length &&
                e.questions.length <= s[s.length - 1] &&
                o(null, e.questions.length);
            }, [e.bookMarked]);
          const o = (n, s) => {
              if ((n && n.preventDefault(), i === s)) return;
              let o = [],
                l = s * t.question_number - t.question_number,
                u = s * t.question_number;
              for (let e = l; e < u; e++) o.push(e);
              a(o), e.update(o, "show"), r(s);
            },
            l = (n = null, r) => {
              n && n.preventDefault();
              let o = [...s],
                l = [];
              if (
                t.question_number &&
                "undefined" != t.question_number &&
                t.question_number > 0
              )
                if (r > 0) {
                  let n;
                  n =
                    t.question_number + o[o.length] > e.questions.length
                      ? e.questions.length
                      : o[o.length - 1] + t.question_number + 1;
                  for (let e = o[o.length - 1] + 1; e < n; e++) l.push(e);
                  let s = i;
                  s++, a(l);
                } else {
                  for (let e = o[0] - 1; e >= o[0] - t.question_number; e--)
                    l.unshift(e);
                  let e = i;
                  e--, a(l);
                }
              e.update(l, "show");
            };
          return t && t.meta && e.questions && e.questions.length
            ? Qt(
                "div",
                { class: "quiz_pagination_wrapper buttons has-addons" },
                e.questions[s[0] - 1] && "undefined" != e.questions[s[0] - 1]
                  ? Qt(
                      "span",
                      {
                        href: "#",
                        className: "button ques_link left prevq",
                        onClick: (e) => {
                          l(e, -1);
                        },
                      },
                      Qt("i", {
                        className: "vicon vicon-angle-left",
                        "aria-hidden": "true",
                      })
                    )
                  : Qt(
                      "span",
                      {
                        href: "#",
                        className: "button ques_link left prevq faded",
                      },
                      Qt("i", {
                        className: "vicon vicon-angle-left",
                        "aria-hidden": "true",
                      })
                    ),
                (() => {
                  let n = Math.ceil(e.questions.length / t.question_number),
                    s = n,
                    a = [],
                    r = 0;
                  if (n > 1)
                    for (; n; )
                      if (n) {
                        let e = n;
                        i == e
                          ? a.unshift(
                              Qt(
                                "span",
                                {
                                  className: "button active",
                                  onClick: (t) => {
                                    o(t, e);
                                  },
                                },
                                n
                              )
                            )
                          : (i - 1 >= 1 || i + 1 <= s) &&
                            (i - 1 == e || i + 1 == e || 1 == e || e == s
                              ? a.unshift(
                                  Qt(
                                    "span",
                                    {
                                      className: "button",
                                      onClick: (t) => {
                                        o(t, e);
                                      },
                                    },
                                    n
                                  )
                                )
                              : r < 2 &&
                                (a.unshift(
                                  Qt("span", { className: "button" }, "...")
                                ),
                                r++)),
                          n--;
                      }
                  return a;
                })(),
                e.questions[s[s.length - 1] + 1] &&
                  "undefined" != e.questions[s[s.length - 1] + 1]
                  ? Qt(
                      "span",
                      {
                        href: "#",
                        className: "button ques_link right nextq",
                        onClick: (e) => {
                          l(e, 1);
                        },
                      },
                      Qt("i", {
                        className: "vicon vicon-angle-right",
                        "aria-hidden": "true",
                      })
                    )
                  : Qt(
                      "span",
                      {
                        href: "#",
                        className: "button ques_link right nextq faded",
                      },
                      Qt("i", {
                        className: "vicon vicon-angle-right",
                        "aria-hidden": "true",
                      })
                    )
              )
            : "";
        },
        {
          createElement: nn,
          render: sn,
          useState: an,
          useEffect: rn,
          Fragment: on,
          RawHTML: ln,
        } = wp.element,
        un = (e) =>
          nn(
            on,
            null,
            e.active
              ? nn(
                  "div",
                  { className: "confirmpopup_wrapper" },
                  nn(
                    "div",
                    { className: "confirmpopup_content" },
                    nn("div", {
                      dangerouslySetInnerHTML: { __html: e.content },
                    }),
                    nn(
                      "div",
                      { className: "buttons_wrapper" },
                      nn(
                        "span",
                        {
                          className: "button",
                          onClick: (t) => {
                            e.yesfunction, e.update(e.type, "trigger");
                          },
                        },
                        e.yes
                      ),
                      nn(
                        "span",
                        {
                          className: "button",
                          onClick: (t) => {
                            e.update(e.type, "nottrigger");
                          },
                        },
                        e.no
                      )
                    )
                  )
                )
              : ""
          ),
        {
          createElement: cn,
          render: dn,
          useState: mn,
          useEffect: pn,
          Fragment: _n,
        } = wp.element;
      function hn(e) {
        if (null == e) return !0;
        if (void 0 === e) return !0;
        if ("number" == typeof e) return !1;
        if (Array.isArray(e) || "string" == typeof e || e instanceof String)
          return 0 === e.length;
        for (var t in e) if (e.hasOwnProperty(t)) return !1;
        return !0;
      }
      const wn = (e) => {
          const [t, n] = mn(e.quiz),
            [s, a] = mn(!1),
            [i, r] = mn(""),
            [o, l] = mn({}),
            [u, c] = mn({});
          return (
            pn(() => {
              let t = 0,
                n = 0,
                s = 0,
                a = 0;
              if (
                e.quiz &&
                e.quiz.meta &&
                e.quiz.meta.questions &&
                (e.quiz.meta.questions.map((e, i) => {
                  e.hasOwnProperty("usercorrect") &&
                  e.hasOwnProperty("marked_answer") &&
                  !hn(e.marked_answer)
                    ? parseInt(e.usercorrect) > 0
                      ? t++
                      : n++
                    : s++,
                    a++;
                }),
                c({ correct: t, incorrect: n, ommitted: s }),
                "" != i)
              ) {
                let e = {
                    datasets: [
                      {
                        data: [t, n, s],
                        backgroundColor: ["#82c362", "#dc6a6a", "#5381ab"],
                      },
                    ],
                    labels: [
                      window.wplms_course_data.translations.correct +
                        " (" +
                        t +
                        ") (" +
                        Math.round((t / a) * 100) +
                        "%)",
                      window.wplms_course_data.translations.incorrect +
                        " (" +
                        n +
                        ") (" +
                        Math.round((n / a) * 100) +
                        "%)",
                      window.wplms_course_data.translations.unattempted +
                        " (" +
                        s +
                        ") (" +
                        Math.round((s / a) * 100) +
                        "%)",
                    ],
                  },
                  r = new Chart(i, { type: "pie", data: e });
                l(r);
              }
            }, [i]),
            cn(
              "div",
              { className: "quiz_stats_chart" },
              t &&
                t.meta &&
                t.meta.questions &&
                t.meta.questions.length &&
                t.submitted
                ? cn(
                    _n,
                    null,
                    o && u
                      ? cn(
                          "div",
                          { className: "quiz_stats_chart_pie" },
                          cn("canvas", {
                            ref: (e) => {
                              e && "" == i && r(e);
                            },
                          })
                        )
                      : "",
                    cn(
                      "div",
                      { className: "question_stats_content_wrapper" },
                      cn(
                        "span",
                        { className: "question_stats_content_heading" },
                        window.wplms_course_data.translations.historical
                      ),
                      cn(
                        "div",
                        { className: "question_stats_content" },
                        t.meta.questions.map((e, t) => {
                          if (e.hasOwnProperty("correct_data"))
                            return cn(
                              "div",
                              {
                                className:
                                  e.hasOwnProperty("user_marks") &&
                                  e.user_marks &&
                                  parseFloat(e.user_marks) > 0
                                    ? "checked_answer correct"
                                    : "checked_answer incorrect",
                              },
                              cn(
                                "span",
                                null,
                                window.wplms_course_data.translations.q,
                                t + 1
                              ),
                              cn("span", null, e.correct_data, "%")
                            );
                        })
                      ),
                      t.hasOwnProperty("tags_data") && !hn(t.tags_data)
                        ? cn(
                            _n,
                            null,
                            cn(
                              "span",
                              { className: "question_stats_content_heading" },
                              window.wplms_course_data.translations
                                .correct_by_tag
                            ),
                            cn(
                              "div",
                              { className: "question_stats_content" },
                              t.tags_data.map((e) =>
                                cn(
                                  "div",
                                  { className: "checked_answer correct" },
                                  cn("span", {
                                    dangerouslySetInnerHTML: {
                                      __html: e.label,
                                    },
                                  }),
                                  cn("span", null, e.value, "%")
                                )
                              )
                            )
                          )
                        : ""
                    )
                  )
                : ""
            )
          );
        },
        {
          createElement: gn,
          render: fn,
          useState: vn,
          useEffect: yn,
          Fragment: bn,
        } = wp.element,
        { dispatch: kn, select: qn } = wp.data,
        xn = (e) => {
          const [t, n] = vn([]),
            [s, a] = vn(null),
            [i, r] = vn(!0),
            [o, l] = vn(null),
            [u, c] = vn(!1);
          yn(() => {
            let e = qn("vibebp").getToken();
            !(function (e) {
              if (null == e) return !0;
              if ("number" == typeof e) return !0;
              if (
                Array.isArray(e) ||
                "string" == typeof e ||
                e instanceof String
              )
                return 0 === e.length;
              for (var t in e) if (e.hasOwnProperty(t)) return !1;
              return !0;
            })(e)
              ? (d(e), a(e))
              : localforage.getItem("bp_login_token").then((t) => {
                  (e = t), d(e), a(e);
                });
          }, [e.quizid]);
          const d = (t) => {
            fetch(
              window.wplms_course_data.api_url +
                "/user/quiz/previousresults/" +
                e.quizid,
              {
                method: "post",
                headers: window.vibebp.xnonce
                  ? { "X-WP-Nonce": window.vibebp.xnonce }
                  : {},
                body: JSON.stringify({ token: t }),
              }
            )
              .then((e) =>
                e.ok
                  ? e.json()
                  : {
                      status: 0,
                      message:
                        window.wplms_course_data.translations
                          .error_loading_data,
                    }
              )
              .then((e) => {
                e && e.length && n(e), r(!1);
              })
              .catch((e) => {
                r(!1),
                  console.error("Uh oh, an error!", e),
                  kn("vibebp").addNotification({
                    text: window.wplms_course_data.translations
                      .error_loading_data,
                  });
              });
          };
          return !i && t.length
            ? gn(
                "div",
                { className: "previous_results_wrapper" },
                gn(
                  "h3",
                  {
                    className: "subtitle",
                    onClick: () => {
                      c(!u);
                    },
                  },
                  gn(
                    "span",
                    null,
                    window.wplms_course_data.translations.previous_results
                  ),
                  " ",
                  gn("span", {
                    className: u ? "vicon vicon-minus" : "vicon vicon-plus",
                  })
                ),
                u
                  ? o && o.hasOwnProperty("id")
                    ? gn(
                        "div",
                        { className: "single_quiz_result quiz_results" },
                        gn("span", {
                          className: "vicon vicon-arrow-left",
                          onClick: () => {
                            l(null);
                          },
                        }),
                        gn(Os, { quizid: e.quizid, activity: o.id })
                      )
                    : gn(
                        "div",
                        null,
                        t.length
                          ? gn(
                              "ul",
                              { className: "quiz_results" },
                              t.map((e) =>
                                gn(
                                  "li",
                                  {
                                    className: "result",
                                    onClick: () => {
                                      l(e);
                                    },
                                  },
                                  gn("span", {
                                    dangerouslySetInnerHTML: {
                                      __html: e.content,
                                    },
                                  })
                                )
                              )
                            )
                          : gn(
                              "div",
                              { className: "vbp_message message" },
                              window.wplms_course_data.translations
                                .results_not_available
                            )
                      )
                  : ""
              )
            : "";
        },
        {
          createElement: Nn,
          render: zn,
          useState: On,
          useEffect: Sn,
          Fragment: En,
        } = wp.element,
        Pn = (e) =>
          e.quiz &&
          e.quiz.meta &&
          e.quiz.meta.questions &&
          e.quiz.meta.questions.length
            ? Nn(
                "div",
                { className: "course_status" },
                Nn(
                  "div",
                  { className: "incourse" },
                  Nn("div", {
                    className: "quiz_content",
                    dangerouslySetInnerHTML: {
                      __html: e.quiz && e.quiz.content ? e.quiz.content : "",
                    },
                  }),
                  Nn(
                    "div",
                    { className: "quiz_questions_content" },
                    Nn(
                      "h1",
                      null,
                      Nn(
                        "span",
                        { className: "student_score" },
                        e.quiz.marks + "/" + e.quiz.max_marks
                      ),
                      e.quiz.quiz_passing_score
                        ? Nn(
                            "span",
                            null,
                            e.quiz.marks > e.quiz.quiz_passing_score
                              ? window.wplms_course_data.translations.passed
                              : window.wplms_course_data.translations.failed
                          )
                        : ""
                    ),
                    e.quiz.meta.questions.map((t, n) => {
                      let s = "",
                        a = "";
                      return (
                        t.hasOwnProperty("show_hint") && t.show_hint
                          ? ((a = "question_hint_content message show"),
                            (s = "question_hint show"))
                          : ((a = "question_hint_content message"),
                            (s = "question_hint")),
                        Nn(
                          "div",
                          { className: "question" },
                          Nn(
                            "div",
                            { className: "question_actions" },
                            Nn(
                              "span",
                              null,
                              window.wplms_course_data.translations
                                .question_full_prefix,
                              " ",
                              n + 1
                            ),
                            Nn(
                              "div",
                              null,
                              Nn(
                                "span",
                                { className: "marks" },
                                Nn("i", { className: "vicon vicon-medall" }),
                                t.marks
                              )
                            )
                          ),
                          e.renderSwitch(t, n),
                          t.attempted &&
                            t.show_correct_answer &&
                            t.explanation.length
                            ? Nn(
                                En,
                                null,
                                Nn(
                                  "div",
                                  { className: "answers" },
                                  t.hasOwnProperty("correct")
                                    ? Nn(
                                        "div",
                                        { className: "correct_answer" },
                                        Nn(
                                          "label",
                                          null,
                                          window.wplms_course_data.translations
                                            .correct_answer
                                        ),
                                        Nn("div", {
                                          dangerouslySetInnerHTML: {
                                            __html: t.correct,
                                          },
                                        })
                                      )
                                    : "",
                                  t.hasOwnProperty("marked") && t.marked
                                    ? Nn(
                                        "div",
                                        { className: "marked_answer" },
                                        Nn(
                                          "label",
                                          null,
                                          window.wplms_course_data.translations
                                            .marked_answer
                                        ),
                                        Nn("div", {
                                          dangerouslySetInnerHTML: {
                                            __html: t.marked,
                                          },
                                        })
                                      )
                                    : ""
                                ),
                                Nn(
                                  "div",
                                  { className: "explanation" },
                                  Nn(
                                    "strong",
                                    null,
                                    window.wplms_course_data.translations
                                      .question_explanation
                                  ),
                                  Nn("div", {
                                    dangerouslySetInnerHTML: {
                                      __html: t.explanation,
                                    },
                                  })
                                )
                              )
                            : ""
                        )
                      );
                    }),
                    Nn(
                      "style",
                      null,
                      '\n\t:root { --body: #fafafa; --highlight: #fff; --text: #475F7B; --bold: #394C62; --primary: #5A8DEE; --secondary: #475F7B; --success: #39DA8A; --primarycolor: #fff; --sidebar: #f4f4ff; --border: rgba(0,0,0,0.08); --darkborder: rgba(0,0,0,0.3); --blue: #5A8DEE; --indigo: #6610F2; --purple: #6F42C1; --pink: #E83E8C; --red: #FF5B5C; --orange: #FD7E14; --yellow: #FDAC41; --green: #39DA8A; --cyan: #00CFDD; --white: #FFFFFF; --gray: #475F7B; --gray-dark: #394C62; --info: #00CFDD; --warning: #FDAC41; --danger: #FF5B5C; --light: #A3AFBD; --dark: #394C62; --error: #ffe27e; --errortext: #725906; --shadow: rgba(0,0,0,0.2); } \n\t.correct_answer { margin-bottom: 1rem;border-bottom:1px solid rgba(0,0,0,0.1); } \n\t.course_status .incourse > * { margin: 0.5rem; } .course_status .incourse .quiz_pagination_wrapper { margin: 1.5rem 0; } .course_status .incourse .quiz_pagination_wrapper .buttons { align-items: center; display: flex; flex-wrap: wrap; justify-content: flex-start; } .course_status .incourse .quiz_pagination_wrapper .question .button { width: auto !important; display: inline-block !important; height: auto !important; } .course_status .incourse .quiz_pagination_wrapper > .button { background: var(--highlight) !important; color: var(--bold) !important; border: 1px solid var(--border) !important; min-width: auto !important; margin: 0; text-align: center; border-radius: 0; padding: 12px 0; width: 48px !important; } .course_status .incourse .quiz_pagination_wrapper > .button.right { float: none; } .course_status .incourse .quiz_pagination_wrapper > .button.active { background: var(--primary) !important; color: var(--primarycolor) !important; } .course_status .incourse .quiz_pagination_wrapper > .button.ques_link { min-with: auto !important; } .course_status .incourse .quiz_stats_chart { display: flex; flex-direction: row; flex-wrap: wrap; } .course_status .incourse .quiz_stats_chart .quiz_stats_chart_pie { width: 340px; } .course_status .incourse .quiz_stats_chart .question_stats_content_wrapper { width: calc(100% - 340px); margin-bottom: 1rem; } .course_status .incourse .quiz_stats_chart span.question_stats_content_heading { margin-bottom: 1rem; display: inline-block; } .course_status .incourse .quiz_stats_chart span.question_stats_content_heading:not(:nth-child(1)) { margin-top: 1.5rem; } .course_status .incourse .quiz_stats_chart .question_stats_content { display: flex; flex-wrap: wrap; margin: 0 -5px; } .course_status .incourse .quiz_stats_chart .question_stats_content > * { margin: 5px; } .course_status .incourse .question_wrapper { min-height: 100px; position: absolute; overflow: hidden; left: 0; top: 0; width: 100%; height: 100%; z-index: 99; text-align: center; transition: all 200ms ease-in; } .course_status .incourse .question_wrapper.loaded .result { transform: translateX(40%); } .course_status .incourse .question_wrapper.loaded .result .correct > span, .course_status .incourse .question_wrapper.loaded .result .incorrect > span { transform: scale(1); } .course_status .incourse .question_wrapper .fillblank_area { clear: none; display: inline-block; } .course_status .incourse .question_wrapper .result { transition: all 200ms ease-in; } .course_status .incourse .question_wrapper .incorrect, .course_status .incourse .question_wrapper .correct { display: inline-block; margin-top: 15px; padding: 10px; } .course_status .incourse .question_wrapper .incorrect strong { color: #ef614d; font-size: 48px; line-height: 64px; margin: 0 10px; font-weight: 600; } .course_status .incourse .question_wrapper .incorrect > span { background: #ef614d; } .course_status .incourse .question_wrapper .incorrect > span:before { content: "e646"; font-family: vicon; color: #fff; font-weight: 900; position: absolute; font-size: 3rem; top: 50%; left: 50%; transform: translate(-50%, -50%); } .course_status .incourse .question_wrapper .correct strong { font-size: 48px; line-height: 64px; margin: 0 10px; font-weight: 600; color: #75b733; } .course_status .incourse .question_wrapper .correct > span:before { content: "e64c"; font-family: vicon; color: #fff; font-weight: 900; position: absolute; font-size: 3rem; top: 50%; left: 50%; transform: translate(-50%, -50%); } .course_status .incourse .question_wrapper span { position: relative; width: 64px; height: 64px; float: left; border-radius: 50%; background: #75b733; display: block; padding: 30px; transform: scale(15); transition: all 200ms ease-in-out; } .course_status .incourse .question_wrapper span .correct > span:before { font-family: fonticon; top: 18px; left: 18px; content: "e038"; color: #FFF; font-size: 30px; line-height: 1; position: absolute; } .course_status .incourse .checked_answer { margin: 2.5rem 0 0; padding: 1rem; font-size: 1.2rem; color: var(--bold); border: 1px solid var(--border); background-color: var(--sidebar); border-radius: 2px; } .course_status .incourse .checked_answer.incorrect { background: #d8eec2; } .course_status .incourse .checked_answer.correct { background: #d8eec2; } .course_status .incourse .checked_answer span { white-space: nowrap; } .course_status .incourse .quiztimer { display: grid; justify-items: center; align-items: center; } .course_status .incourse .quiztimer .circle_timer { display: flex; flex-direction: row; } .course_status .incourse .quiztimer .circle_timer > span { display: flex; justify-content: center; flex-direction: column; } .course_status .incourse .quiztimer .circle_timer .react-progress-circle { display: flex; } .course_status .incourse .quiztimer .timer_amount, .course_status .incourse .quiztimer .timer_unit { color: var(--bold); line-height: 1em; display: grid; grid-template-columns: 1fr 5px 1fr; justify-items: center; } .course_status .incourse .quiztimer .timer_amount span:nth-child(n+4), .course_status .incourse .quiztimer .timer_amount span:nth-child(n+4), .course_status .incourse .quiztimer .timer_unit span:nth-child(n+4), .course_status .incourse .quiztimer .timer_unit span:nth-child(n+4) { display: none; } .course_status .incourse .quiztimer .timer_amount { font-size: 2rem; } .course_status .incourse .quiztimer .timer_amount span { margin: 0 5px; } .course_status .incourse .quiztimer .timer_unit { font-size: 11px; } .course_status .incourse .fillblank_area { clear: none; display: inline-block; } .course_status .incourse span.select_question_content { display: inline-block; } .course_status .incourse .question_content select { margin: 0 5px; } .course_status .incourse .droppable > div { border: 1px solid var(--border); padding: 1rem; cursor: move; } .course_status .incourse .droppable:hover > div { border-color: var(--primary); } .course_status .incourse .droppable.active { overflow-y: scroll; } .course_status .incourse .question .droppable, .course_status .incourse .match_options { touch-action: none; } .course_status .incourse .droppable > div + div { border-top: none; } .course_status .incourse .droppable .dragging { border: 1px solid #f5d01a; box-shadow: 0 0 6px #efc600; } .course_status .incourse .quiz_questions_content .question_actions { margin-top: 1rem; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; align-items: center; font-size: 1.5rem; } .course_status .incourse .quiz_questions_content .question_actions span.button { cursor: pointer; padding: 0.2rem; font-size: 1.2rem; margin: 0; } .course_status .incourse .quiz_questions_content .question_actions > div { display: flex; flex-direction: row; } .course_status .incourse .quiz_questions_content .question_actions > div span { margin: 0 0.2rem; z-index: 11; } .course_status .incourse .quiz_questions_content .question_actions > div span:not(.marks) { cursor: pointer; } .course_status .incourse .quiz_questions_content .question .marks i.icon-check-5:before { content: "e63a"; font-family: vicon; font-weight: 400 !important; font-variant: normal !important; text-transform: none !important; speak: none; line-height: 1; margin: 5px; } .course_status .incourse .question .question_option p { display: inline-block; } .course_status .incourse .question_option { display: block; margin-bottom: 1rem; } .course_status .incourse .question_option label { margin-bottom: 0; } .course_status .incourse .question_option.radio + .radio { margin-left: 0; } .course_status .incourse .match_playground { display: grid; grid-template-columns: 1fr 1fr; justify-content: center; align-items: stretch; grid-gap: 1rem; margin: 1rem 0; } .course_status .incourse .match_playground .droppable { border: 1px solid rgba(0, 0, 0, 0.2); } .course_status .incourse .match_playground .match_options .match_option { border: 1px solid rgba(0, 0, 0, 0.08); padding: 2rem; } .course_status .incourse .match_playground .droppable { display: grid; grid-template-columns: 1fr; grid-gap: 10px; padding: 30px; justify-content: center; align-items: center; } .course_status .incourse .match_playground .droppable > div { border-top: 1px solid var(--border); } .course_status .incourse .match_playground .match_option { background: var(--border); } .course_status .incourse .match_playground .match_option .children > div { border: 1px solid var(--border); padding: 1rem; background: var(--highlight); } .course_status .incourse .quiz_questions_content { flex: 3 0 480px; max-width: 100%; } .course_status .incourse .quiz_questions_content .question_content { padding: 1rem 0; border-top: none; } .course_status .incourse .quiz_questions_content .question { position: relative; border-bottom: 1px solid rgba(0,0,0,0.1); } .course_status .incourse .quiz_questions_content .question .question_hint { cursor: pointer; margin-right: 5px; } .course_status .incourse .quiz_questions_content .question .question_hint:before { content: "e718"; font-family: vicon; font-size: 22px; } .course_status .incourse .quiz_questions_content .question .question_hint.show:before { content: "e646"; } .course_status .incourse .quiz_questions_content .question .question_hint span.question_hint_content { transform: scale(0); padding: 1rem; background: var(--sidebar); border-radius: 5px; margin: 1rem 0; opacity: 0; transition: 0.2s all; } .course_status .incourse .quiz_questions_content .question .question_hint span.question_hint_content.show { transform: scale(1); opacity: 1; } .course_status .incourse .quiz_questions_content .question .explanation { /* padding: 1rem; */ /* font-size: 1.2rem; */ border: 1px solid var(--border); background: var(--highlight); z-index: 99; position: relative; margin: 1rem 0; } .course_status .incourse .quiz_questions_content .question_wrapper.loaded .result { transform: translate(0, -24px) scale(0.75); } .course_status .incourse div.sort_options { touch-action: none; } .course_status .incourse .single-quiz .question .question_content:first-child { border-top: none; } .course_status .incourse .quiz_questions li > strong { display: block; margin: 5px 0; } .course_status .incourse .incoursequiz_details { display: flex; flex: 1 0 240px !important; max-width: 100%; flex-direction: column; justify-content: space-between; align-items: baseline; align-items: center; margin-bottom: 1.5rem; flex: 1; z-index: 999; padding: 0.5rem; position: sticky; top: 3rem; background: var(--highlight); bordeR: 1px solid var(--border); border-radius: 5px; align-items: center; transition: 0.5s all; margin: 1rem 0; } .course_status .incourse .incoursequiz_details > div { display: flex; flex-wrap: wrap; justify-content: space-between; margin: 0 -0.5rem; align-items: center; width: 100%; } .course_status .incourse .incoursequiz_details > div > * { margin: 0.5rem; } .course_status .incourse .incoursequiz_details > div strong { flex: 1; } .course_status .incourse .incoursequiz_details > div strong .student_score { font-size: 1.8rem; } .course_status .incourse .incoursequiz_details > div strong .student_quiz_status { opacity: 0.7; font-size: 75%; margin: 0 0.75rem; } .course_status .incourse .incoursequiz_details > div .show_questions { display: flex; align-items: center; } .course_status .incourse .incoursequiz_details > div .show_questions > span:not(.vicon) { font-size: 11px; opacity: 0.5; text-transform: uppercase; } .course_status .incourse .incoursequiz_details .incourse_quiz_button > a { flex: 1; margin: 0 1rem; } .course_status .incourse .incoursequiz_details .quiz_timeline { min-width: 160px; margin: 0; padding: 0; max-height: none; overflow: hidden; } .course_status .incourse .incoursequiz_details .quiz_timeline li.done > span { display: flex; align-items: center; flex-direction: row-reverse; } .course_status .incourse .incoursequiz_details .quiz_timeline li.done > span:before { position: relative; color: var(--primary); } .course_status .incourse .incoursequiz_details .quiz_timeline li.done.active > span:before { color: var(--primarycolor); } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper { border: none; justify-content: center; align-items: center; display: flex; } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul { display: flex; flex-wrap: wrap; margin: -0.25rem; font-size: 0.8rem; } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul li { margin: 0.25rem; padding: 5px; border-radius: 2px; border: none; display: flex; width: 32px; height: 24px; align-items: center; border: 1px solid var(--border); cursor: pointer; } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul li.bookmarked { box-shadow: 0 2px 2px var(--shadow); } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul li.done { background: var(--border); } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul li.done > span:before { content: "e64c"; font-family: vicon; } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul li.done.correct { color: #fff; background: rgba(0, 128, 0, 0.5); } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul li.done.incorrect { color: #fff; background: rgba(255, 0, 0, 0.5); } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul li.done.incorrect > span:before { content: "e646"; } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul li.active { background: var(--primary); color: var(--primarycolor); } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul li > span { position: relative; width: 100%; text-align: center; margin: 0; height: auto; background: none; border-radius: 0; bordeR: none; top: auto; left: auto; } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul > span { display: flex; align-items: center; margin: 0 0.5rem; } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper > ul > span > span:not(.vicon) { font-size: 11px; opacity: 0.5; text-transform: uppercase; } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper.question_numbers ul > li { width: auto !important; white-space: nowrap; } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper.question_numbers ul > li:before { content: attr(data-number); } .course_status .incourse .incoursequiz_details .quiz_timeline .timeline_wrapper.question_numbers ul > li > span { padding: 0 5px; background: var(--border); margin: -2px -2px -2px 5px; border-radius: 2px; } .course_status .incourse span.question_hint_content { transform: scale(0); padding: 1rem; background: var(--sidebar); border-radius: 5px; margin: 1rem 0; opacity: 0; transition: 0.2s all; } .course_status .incourse span.question_hint_content.show { transform: scale(1); opacity: 1; } .course_status .incourse .question_option .radio > input[type=radio] + label, .course_status .incourse .question_option .checkbox > input[type=radio] + label { display: flex; align-items: center; } .course_status .incourse div#unit.quiz_title h1 { width: 50%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; } .course_status .incourse div#unit.quiz_title h5 { font-size: 14px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; } .course_status .incourse .loading_quiz.disabled { display: none; } .course_status .incourse .loading_quiz { position: fixed !important; width: 0%; height: 0%; left: 50%; top: 50%; z-index: 9999; } .course_status .incourse .question_correct { border: 2px solid rgba(0, 128, 0, 0.5) !important; padding: 5px; border-radius: 5px; } .course_status .incourse .question_incorrect { border: 2px solid rgba(255, 0, 0, 0.5) !important; padding: 5px; border-radius: 5px; } .course_status .incourse .quiz_questions_content { flex: 3 0 640px; max-width: 100%; } .course_status .incourse .quiz_questions_content .question_option.radio label > div, .course_status .incourse .quiz_questions_content .question_option.checkbox label > div { display: inline-block; } .course_status .incourse .quiz_questions_content .question_option.radio label > div > p, .course_status .incourse .quiz_questions_content .question_option.checkbox label > div > p { margin: 0; } .course_status .incourse .incourse_quiz_button { display: flex; flex-direction: column; justify-content: space-around; align-items: center; } .course_status .incourse .incourse_quiz_button a { text-align: center; width: 100%; margin: 0.25rem !important; } .course_status .incourse .quiz_retake { display: flex; align-items: center; flex-wrap: wrap; margin: 0 -0.25rem; } .course_status .incourse .quiz_retake > * { flex: 1 0 180px; margin: 0.25rem; } .course_status .incourse .confirmpopup_wrapper { position: fixed; top: 0; left: 0; height: 100vh; width: 100vw; background: rgba(0, 0, 0, 0.5); z-index: 99999; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; } .course_status .incourse .confirmpopup_wrapper .confirmpopup_content { padding: 1rem; background: var(--highlight); border-radius: 5px; min-width: 50%; } .course_status .incourse span.question_stats_content_heading { margin-bottom: 1rem; display: inline-block; } .course_status .incourse span.question_stats_content_heading:not(:nth-child(1)) { margin-top: 1.5rem; } .course_status .incourse .question_stats_content .checked_answer span { text-transform: capitalize; } .course_status .incourse .question_stats_content { display: flex; flex-wrap: wrap; margin: 0 -5px; align-items: start; } .course_status .incourse .question_stats_content > * { margin: 5px; } .course_status .incourse .question_stats_content span { margin: 5px; } .course_status .incourse .question_stats_content .checked_answer { text-align: center; } .course_status .incourse .quiz_stats_chart { display: flex; flex-direction: row; flex-wrap: wrap; } .course_status .incourse .quiz_stats_chart .quiz_stats_chart_pie { flex: 1 0 240px; } .course_status .incourse .quiz_stats_chart .question_stats_content_wrapper { flex: 2 0 480px; } .course_content_content { display: inline-block; width: 100%; padding: 0.75rem 1rem 0; } .course_content_content h2 { font-size: 2.5rem; font-weight: 800; margin: 0 0 1.5rem !important; } .course_content_content .video_wrapper { z-index: 11; } .course_content_content .unit_attachments { background: var(--border); padding: 1rem; margin: 1rem 0; border-radius: 5px; display: flex; flex-direction: column; } .course_content_content .unit_attachments h3 { font-weight: 600; margin-bottom: 0.5rem; } .course_content_content .unit_attachments .attachment { width: 100%; display: flex; flex-direction: row; justify-content: space-between; align-items: center; margin: 0.5rem 0; } .course_content_content .unit_attachments .attachment > span { display: flex; align-items: center; margin: 0 -5px; } .course_content_content .unit_attachments .attachment > span span.attachment_icon > svg { width: 32px; fill: var(--text); color: var(--text); } .course_content_content .unit_attachments .attachment > span > * { margin: 0 5px; } .course_content_content .unit_assignments { background: var(--border); padding: 1rem; margin: 1rem 0; border-radius: 5px; display: flex; flex-direction: column; } .course_content_content .unit_assignments h3 { font-weight: 600; margin-bottom: 0.5rem; } .course_content_content .unit_assignments .assignment .assignment_heading { display: flex; justify-content: space-between; padding: 5px 0; } .course_content_content .pratice_questions { margin: 1rem 0; } .course_content_content .pratice_questions .incourse { margin: 1rem 0; background: var(--sidebar); padding: 1rem 1.5rem; border-radius: 8px; } .course_content_content .pratice_questions .incourse .quiz_questions_content { margin: 0; } .finish-course-content { display: flex; flex-direction: column; justify-content: center; text-align: center; padding-top: 60px; } .finish-course-content h1 { font-size: 3rem; } .finish-course-content h2 { font-size: 2.5rem; } .finish-course-content h3 { font-size: 1.8rem; } .finish-course-content .post_completion_message { flex: 1; max-height: calc(100vh - 550px); overflow-y: auto; min-height: 100px; } .finish-course-content .vibe_editor_rich_text { text-align: start; } .finish-course-content .completion_message { font-size: 1.2rem; margin: 1rem 0; } .finish-course-content .awards { display: flex; align-items: baseline; justify-content: center; margin: 1.5rem 0; } .finish-course-content .awards .certificate svg, .finish-course-content .awards .badge img { fill: var(--light); width: 64px; height: 64px; border-radius: 5px; } .finish-course-content .awards > * { margin: 1rem 0.5rem; display: flex; flex-direction: column; justify-content: center; align-items: center; background: #fafafa; padding: 1rem; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); border-radius: 5px; width: 128px; transition: all 0.2s; font-size: 1rem; font-weight: 600; } .finish-course-content .awards > *:hover { box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); transform: translateY(-2px); } .finish-course-content .finished_percentage { display: flex; align-items: center; justify-content: center; margin: 0; position: absolute; top: -90px; right: calc(50% - 90px); } .finish-course-content .finished_percentage > span { width: 180px; height: 180px; font-weight: 800; display: flex; flex-direction: column; line-height: 0; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.6rem; font-weight: 600; color: var(--primarycolor); background: var(--primary); box-shadow: 0 -1px 1rem var(--highlight); } .finish-course-content .finished_percentage > span:before { position: absolute; content: \'\'; width: 100%; height: 100%; border: 10px solid #fff; box-shadow: inset 0 1px 10px rgba(0, 0, 0, 0.4); border-radius: 50%; z-index: 0; } .finish-course-content .finished_percentage > span > span { line-height: 1; font-size: 11px; display: flex; flex-wrap: wrap; letter-spacing: 1px; position: relative; font-weight: 800; font-size: 11px; letter-spacing: 2px; } .finish-course-content .finished_percentage > span > span + span { width: 80%; } .finish-course-content .finished_percentage > span > span strong { font-size: 4rem; color: var(--primarycolor); margin-left: -0.5rem; } .finish-course-content .finished_percentage > span > span strong + span { font-size: 1rem; position: absolute; margin-top: 1rem; right: -1rem; top: 0; } .quiz_bar { background: var(--highlight); padding: 0.5rem; margin: 1rem 0; align-items: center; display: inline-block; width: 100%; } .quiz_pagination_wrapper .faded { opacity: 0.45; } .quiztimer { display: flex; justify-content: center; } .quiztimer .c100.big { font-size: 10rem; } .quiztimer .c100.big > span { font-size: 1.5rem; display: flex; flex-direction: column; line-height: 1.5; } .quiztimer .c100.big > span span.timer_amount, .quiztimer .c100.big > span span.timer_unit { display: flex; align-items: center; justify-content: center; } .quiztimer .c100.big > span span.timer_amount > span + span, .quiztimer .c100.big > span span.timer_unit > span + span { margin-left: 2px; } .quiztimer .c100.big > span > span.timer_unit { font-size: 0.7rem; opacity: 0.5; } .quiztimer .c100.big:after { border: 1px dashed rgba(0, 0, 0, 0.05); } .answers { margin: 0.5rem 0; }\n\t'
                    )
                  )
                )
              )
            : "",
        {
          Component: In,
          createElement: Cn,
          render: Mn,
          useState: Ln,
          useEffect: Tn,
          Fragment: An,
        } = wp.element,
        Dn = (e) => {
          const [t, n] = Ln(e.duration),
            [s, a] = Ln({ d: 0, h: 0, m: 0, s: 0 });
          Tn(() => {
            e.start
              ? setTimeout(() => {
                  let s = t - 1;
                  s <= -1
                    ? e.update(e.quiz_id, "expired")
                    : s >= 0 && (n(s), i());
                }, 1e3)
              : (n(e.duration), i());
          }, [t, e.start, e.duration]);
          const i = () => {
            let e = { ...s },
              n = t;
            n > 86400
              ? ((e.d = Math.floor(n / 86400)), (n -= 86400 * e.d))
              : (e.d = 0),
              n > 3600
                ? ((e.h = Math.floor(n / 3600)), (n -= 3600 * e.h))
                : (e.h = 0),
              n > 60
                ? ((e.m = Math.floor(n / 60)), (n -= 60 * e.m))
                : (e.m = 0),
              (e.s = n),
              a(e);
          };
          return Cn(
            "div",
            { className: "driptimer_wrapper" },
            Cn(
              "div",
              { className: "driptimer" },
              Cn(
                "span",
                { className: "timer_amount" },
                s.d
                  ? Cn(An, null, Cn("span", null, s.d), Cn("span", null, ":"))
                  : "",
                s.h
                  ? Cn(An, null, Cn("span", null, s.h), Cn("span", null, ":"))
                  : "",
                s.m
                  ? Cn(An, null, Cn("span", null, s.m), Cn("span", null, ":"))
                  : "",
                Cn("span", null, s.s)
              ),
              Cn(
                "span",
                { className: "timer_unit" },
                s.d
                  ? Cn(
                      An,
                      null,
                      Cn(
                        "span",
                        null,
                        window.wplms_course_data.translations.days
                      ),
                      Cn("span", null)
                    )
                  : "",
                s.h
                  ? Cn(
                      An,
                      null,
                      Cn(
                        "span",
                        null,
                        window.wplms_course_data.translations.hours
                      ),
                      Cn("span", null)
                    )
                  : "",
                s.m
                  ? Cn(
                      An,
                      null,
                      Cn(
                        "span",
                        null,
                        window.wplms_course_data.translations.minutes
                      ),
                      Cn("span", null)
                    )
                  : "",
                Cn("span", null, window.wplms_course_data.translations.seconds)
              )
            )
          );
        },
        {
          createElement: $n,
          render: Fn,
          useState: jn,
          useEffect: Hn,
          Fragment: Bn,
        } = wp.element,
        { dispatch: Rn, select: Un } = wp.data,
        {
          createElement: Jn,
          useState: Xn,
          useEffect: Wn,
          Fragment: Yn,
          render: Vn,
        } = wp.element,
        { dispatch: Qn, select: Kn } = wp.data,
        Gn = (e) => {
          const [t, n] = Xn({});
          return (
            Wn(() => {
              let t = "",
                s = "";
              switch (e.type) {
                case "friends":
                  (s = "user"), (t = e.id.item_id);
                  break;
                case "forum":
                  (s = "forum"), (t = e.id.item_id);
                  break;
                case "group":
                  (s = "group"), (t = e.id.item_id);
                  break;
                case "activity":
                  (s = "user"), (t = e.id.secondary_item_id);
                  break;
                case "member":
                case "name":
                case "user_tip":
                case "user":
                  (s = "user"), (t = e.id.user_id);
                  break;
                default:
                  (s = e.type), (t = e.id.item_id);
              }
              s || (s = "user");
              let a = Kn("vibebp").getData(s + "_" + t);
              a
                ? n(a)
                : localforage.getItem(s + "_" + t).then((a) => {
                    null !== a
                      ? (n(JSON.parse(a)),
                        Qn("vibebp").setData(s + "_" + t, JSON.parse(a)))
                      : fetch(
                          `${window.vibebp.api.url}/avatar?id=${
                            s + "_" + t
                          }&client_id=${window.vibebp.settings.client_id}`,
                          {
                            method: "post",
                            body: JSON.stringify({
                              type: e.type,
                              ids: e.id,
                              token: Kn("vibebp").getToken(),
                            }),
                          }
                        )
                          .then((e) => e.json())
                          .then((e) => {
                            e.hasOwnProperty("avatar") &&
                              (Qn("vibebp").setData(s + "_" + t, e),
                              localforage.setItem(
                                s + "_" + t,
                                JSON.stringify(e)
                              ),
                              n(e));
                          });
                  });
            }, [e.id.item_id, e.id.user_id]),
            t.hasOwnProperty("avatar") || t.hasOwnProperty("name")
              ? "member" == e.type
                ? React.createElement(
                    "span",
                    { className: "vibebp_member" },
                    React.createElement("img", {
                      src: t.avatar,
                      className: "vibebp_avatar",
                      onClick: e.click,
                      alt: t.name,
                      title: t.name,
                    }),
                    React.createElement("span", null, t.name)
                  )
                : "group" == e.type
                ? React.createElement(
                    "span",
                    { className: "vibebp_group" },
                    React.createElement("img", {
                      src: t.avatar,
                      className: "vibebp_avatar",
                      onClick: e.click,
                      alt: t.name,
                      title: t.name,
                    }),
                    React.createElement("span", null, t.name)
                  )
                : "user_tip" == e.type
                ? React.createElement(
                    "span",
                    { className: "vibebp_member tip", title: t.name },
                    React.createElement("img", {
                      src: t.avatar,
                      className: "vibebp_avatar",
                      onClick: e.click,
                      alt: t.name,
                      title: t.name,
                    })
                  )
                : "name" == e.type || "forum" == e.type
                ? React.createElement("span", null, t.name)
                : React.createElement("img", {
                    src: t.avatar,
                    className: "vibebp_avatar",
                    onClick: e.click,
                    alt: t.name,
                    title: t.name,
                  })
              : ""
          );
        },
        {
          createElement: Zn,
          render: es,
          useState: ts,
          useEffect: ns,
          Fragment: ss,
          useRef: as,
        } = wp.element,
        is = (e) => {
          const [t, n] = ts(e.leaderboardData),
            [s, a] = ts(e.quiz),
            i = (function (e) {
              const t = as();
              return (
                ns(() => {
                  t.current = e;
                }, [e]),
                t.current
              );
            })(t);
          ns(() => {
            let t = [...e.leaderboardData];
            t.sort((e, t) => parseFloat(t.marks) - parseFloat(e.marks)), n(t);
          }, [e.leaderboardData]),
            ns(() => {
              a(e.quiz);
            }, [e.quiz]);
          let r = [];
          return (
            t &&
              t.length &&
              i &&
              i.length &&
              t.map((e, t) => {
                let n = i.findIndex((t) => t.id === e.id);
                r[t] =
                  t > n
                    ? "down vicon vicon-arrow-down"
                    : t === n
                    ? ""
                    : "up vicon vicon-arrow-up";
              }),
            Zn(
              "div",
              { className: "live_contest_quiz_leaderboard" },
              Zn(
                "strong",
                null,
                window.wplms_course_data.translations.leaderboard
              ),
              t.length
                ? Zn(
                    "div",
                    { className: "live-leaderboard-list" },
                    Zn(
                      "div",
                      { className: "contest_user contest_table_head" },
                      Zn("span", null),
                      Zn("span", null),
                      Zn(
                        "span",
                        null,
                        window.wplms_course_data.translations.marks
                      ),
                      Zn(
                        "span",
                        null,
                        window.wplms_course_data.translations.attempted
                      )
                    ),
                    t.map((e, t) =>
                      Zn(
                        "div",
                        { className: "contest_user" },
                        Zn("span", null, t + 1),
                        Zn(
                          "span",
                          { className: "member_info" },
                          Zn(Gn, { type: "member", id: { user_id: e.id } }),
                          Zn("span", { className: r[t] })
                        ),
                        Zn("span", null, " ", e.marks, "/", s.meta.max),
                        Zn(
                          "span",
                          null,
                          " ",
                          e.attempted,
                          "/",
                          s.meta.questions.length
                        )
                      )
                    )
                  )
                : Zn(
                    "div",
                    { className: "vbp_message message" },
                    window.wplms_course_data.translations.members_not_found
                  )
            )
          );
        },
        {
          createElement: rs,
          useState: os,
          useEffect: ls,
          Fragment: us,
          render: cs,
          useRef: ds,
        } = wp.element,
        { dispatch: ms, select: ps } = wp.data,
        {
          createElement: _s,
          render: hs,
          useState: ws,
          useEffect: gs,
          useCallback: fs,
          useRef: vs,
          Fragment: ys,
          useLayoutEffect: bs,
        } = wp.element,
        { dispatch: ks, select: qs } = wp.data;
      function xs(e) {
        if (null == e) return !0;
        if ("number" == typeof e) return !1;
        if (Array.isArray(e) || "string" == typeof e || e instanceof String)
          return 0 === e.length;
        for (var t in e) if (e.hasOwnProperty(t)) return !1;
        return !0;
      }
      function Ns(e) {
        if (null == e) return !0;
        if ("number" == typeof e) return !0;
        if (Array.isArray(e) || "string" == typeof e || e instanceof String)
          return 0 === e.length;
        for (var t in e) if (e.hasOwnProperty(t)) return !1;
        return !0;
      }
      function zs(e) {
        try {
          JSON.parse(e);
        } catch (e) {
          return !1;
        }
        return !0;
      }
      const Os = (e) => {
        const [t, n] = ws({}),
          [s, a] = ws("quiz"),
          [i, r] = ws([]),
          o = vs(null),
          [l, u] = ws({}),
          [c, m] = ws("up"),
          [p, _] = ws(!1),
          [h, w] = ws(!1),
          [g, f] = ws(!1),
          [v, y] = ws(!0),
          [b, k] = ws(null),
          [q, x] = ws(null),
          [N, z] = ws([]),
          [O, S] = ws([]),
          [E, P] = ws(!1),
          [I, C] = ws(""),
          [M, L] = ws(qs("vibebp").getUser()),
          [A, D] = ws([]);
        gs(() => {
          let t = qs("vibebp").getToken();
          Ns(t)
            ? localforage.getItem("bp_login_token").then((e) => {
                (t = e), $(t), k(t);
              })
            : ($(t), k(t)),
            document.addEventListener(
              "wplms_answer_question_type",
              ({ detail: e }) => {
                F(e.question, e.index, "changed");
              }
            ),
            localforage
              .getItem("bookmarked_questions_" + e.quizid)
              .then((e) => {
                e && e.length && z(JSON.parse(e));
              });
        }, [e.quizid]),
          gs(() => {
            e &&
              e.hasOwnProperty("non_logged_in_quiz") &&
              e.non_logged_in_quiz &&
              !b &&
              t.hasOwnProperty("id") &&
              (localStorage.setItem("vibequiz_" + t.id, JSON.stringify(t)),
              document.querySelector(".start_quiz_button") &&
                document.querySelector(".start_quiz_button").remove()),
              document.dispatchEvent(new Event("VibeBP_Editor_Content"));
          }, [t]);
        const $ = (t = null, s = null) => {
            t || (t = b), a("quiz");
            let i = { token: t };
            if (
              (e.hasOwnProperty("activity") &&
                e.activity &&
                (i.activity = e.activity),
              e.hasOwnProperty("course") && e.course && (i.course = e.course),
              e.hasOwnProperty("non_logged_in_quiz") &&
                e.non_logged_in_quiz &&
                !t)
            ) {
              let s = localStorage.getItem("vibequiz_" + e.quizid),
                i = "";
              if (void 0 !== s && s) {
                if (((i = JSON.parse(s)), i)) {
                  if ((x(null), i.hasOwnProperty("drip_message"))) n(i);
                  else if (i.meta && i.meta.questions) {
                    let s = 0,
                      a = 0;
                    if (
                      "object" == typeof i.meta.questions &&
                      !Array.isArray(i.meta.questions)
                    ) {
                      let e = [];
                      Object.keys(i.meta.questions).map((t) => {
                        "object" == typeof i.meta.questions[t] &&
                          ((i.meta.questions[t].id = t),
                          e.push(i.meta.questions[t]),
                          (e.id = t));
                      }),
                        (i.meta.questions = e);
                    }
                    i.meta.questions.map((e, t) => {
                      if (e.raw) i.meta.questions[t] = e.raw;
                      else {
                        i.meta.questions[t].show = !1;
                        let n = localStorage.getItem(e.id);
                        !xs(n) &&
                          Ns(e.marked_answer) &&
                          (zs(n)
                            ? (i.meta.questions[t].marked_answer =
                                JSON.parse(n))
                            : (i.meta.questions[t].marked_answer = n));
                      }
                      (s += parseFloat(e.user_marks)), (a += parseInt(e.marks));
                    }),
                      Number.isInteger(s) || (s = s.toFixed(2)),
                      (i.marks = s),
                      (i.max_marks = a),
                      (i.question_number = parseInt(i.question_number));
                    let o = [];
                    if (i.question_number && i.question_number > 0)
                      for (let e = 0; e < i.question_number; e++) o.push(e);
                    if (
                      (r(o),
                      e.hasOwnProperty("non_logged_in_quiz") &&
                        e.non_logged_in_quiz &&
                        !t)
                    ) {
                      let t = localStorage.getItem("quiz_expiry_" + e.quizid);
                      if (void 0 !== t && t) {
                        let e = Math.floor(new Date().getTime() / 1e3);
                        e >= parseInt(t)
                          ? R(i)
                          : (i.remaining = parseInt(t) - e);
                      }
                      let n = localStorage.getItem("quiz_retakes_" + e.quizid);
                      if (
                        n &&
                        ((n = parseInt(n)),
                        i.hasOwnProperty("meta") || (i.meta = {}),
                        i.meta.hasOwnProperty("retakes"))
                      ) {
                        let e = parseInt(i.meta.retakes) - n;
                        e < -1 && (e = 0), (i.meta.retakes = e);
                      }
                    }
                    n(i);
                  }
                  var o = document.createEvent("Event");
                  o.initEvent("unit_traverse", !1, !0),
                    document.querySelector(".unit_content") &&
                      document.querySelector(".unit_content") &&
                      document.querySelector(".unit_content").dispatchEvent(o);
                } else console.log(i);
                return void a(!1);
              }
            }
            let l = window.wplms_course_data.api_url + "/user/quiz/" + e.quizid;
            e.hasOwnProperty("non_logged_in_quiz") &&
              e.non_logged_in_quiz &&
              !t &&
              (l =
                window.wplms_course_data.api_url +
                "/quiz/nonloggedin/" +
                e.quizid +
                "?client_id=" +
                window.wplms_course_data.client_id),
              e.hasOwnProperty("force") &&
                e.force &&
                (l.includes("?client_id") ? (l += "&force") : (l += "?force")),
              s &&
                !l.includes("force") &&
                (l.includes("?") ? (l += "&force") : (l += "?force")),
              i.hasOwnProperty("activity") &&
                i.activity &&
                (/\?/.test(l)
                  ? (l += "&activity=" + i.activity)
                  : (l += "?activity=" + i.activity)),
              fetch(l, {
                method: "post",
                headers: window.vibebp.xnonce
                  ? { "X-WP-Nonce": window.vibebp.xnonce }
                  : {},
                body: JSON.stringify(i),
              })
                .then((e) =>
                  e.ok
                    ? e.json()
                    : {
                        status: 0,
                        message:
                          window.wplms_course_data.translations
                            .error_loading_data,
                      }
                )
                .then((s) => {
                  if (s) {
                    if ((x(null), s.hasOwnProperty("drip_message"))) n(s);
                    else if (s.meta && s.meta.questions) {
                      let t = 0,
                        a = 0;
                      if (
                        "object" == typeof s.meta.questions &&
                        !Array.isArray(s.meta.questions)
                      ) {
                        let e = [];
                        Object.keys(s.meta.questions).map((t) => {
                          "object" == typeof s.meta.questions[t] &&
                            ((s.meta.questions[t].id = t),
                            e.push(s.meta.questions[t]),
                            (e.id = t));
                        }),
                          (s.meta.questions = e);
                      }
                      s.meta.questions.map((e, n) => {
                        if (e.raw) s.meta.questions[n] = e.raw;
                        else {
                          s.meta.questions[n].show = !1;
                          let t = localStorage.getItem(e.id);
                          !xs(t) &&
                            Ns(e.marked_answer) &&
                            (zs(t)
                              ? (s.meta.questions[n].marked_answer =
                                  JSON.parse(t))
                              : (s.meta.questions[n].marked_answer = t));
                          try {
                            JSON.parse(e.correct),
                              e.attempted &&
                                ((s.meta.questions[n].correct = JSON.parse(
                                  bt.AES.decrypt(e.correct, e.key, {
                                    format: kt,
                                  }).toString(bt.enc.Utf8)
                                )),
                                (s.meta.questions[n].correct = qt(e)));
                          } catch (e) {
                            console.log(e);
                          }
                        }
                        (t += parseFloat(e.marks)),
                          (a += parseInt(e.max_marks));
                      }),
                        Number.isInteger(t) || (t = t.toFixed(2)),
                        isNaN(a) || ((s.marks = t), (s.max_marks = a)),
                        (s.question_number = parseInt(s.question_number));
                      let i = [];
                      if (s.question_number && s.question_number > 0)
                        for (let e = 0; e < s.question_number; e++) i.push(e);
                      r(i);
                      let o = Math.floor(new Date().getTime() / 1e3);
                      s.hasOwnProperty("expiry") &&
                        s.expiry > 0 &&
                        (s.expiry > o
                          ? (s.remaining = parseInt(s.expiry) - o)
                          : (s.remaining = 0));
                      let l = localStorage.getItem("quiz_retakes_" + e.quizid);
                      if (
                        l &&
                        ((l = parseInt(l)),
                        s.hasOwnProperty("meta") || (s.meta = {}),
                        s.meta.hasOwnProperty("retakes"))
                      ) {
                        let e = parseInt(s.meta.retakes) - l;
                        e < -1 && (e = 0), (s.meta.retakes = e);
                      }
                      n(s);
                    }
                    s.remaining && s.remaining <= 0 && R(s, t);
                    var i = document.createEvent("Event");
                    i.initEvent("unit_traverse", !1, !0),
                      document.querySelector(".unit_content") &&
                        document.querySelector(".unit_content") &&
                        document
                          .querySelector(".unit_content")
                          .dispatchEvent(i);
                    let a = { ...s };
                    "live_contest" == a.quiz_type &&
                      firebase &&
                      (firebase
                        .database()
                        .ref(`quizes/${a.id}/users`)
                        .once("value", (e) => {
                          D((t) => {
                            let n = [...t];
                            return (
                              e.forEach((e) => {
                                let t = e.val();
                                t &&
                                  -1 == n.findIndex((t) => t.id == e.key) &&
                                  n.push({ ...t, id: e.key });
                              }),
                              n
                            );
                          });
                        }),
                      firebase
                        .database()
                        .ref(`quizes/${a.id}/users`)
                        .on("child_changed", (e) => {
                          D((t) => {
                            let n = [...t],
                              s = n.findIndex((t) => t.id == e.key);
                            return (
                              s > -1 &&
                                n.splice(s, 1, { ...e.val(), id: e.key }),
                              n
                            );
                          });
                        }),
                      firebase
                        .database()
                        .ref(`quizes/${a.id}/users`)
                        .on("child_added", (e) => {
                          D((t) => {
                            let n = [...t],
                              s = n.findIndex((t) => t.id == e.key);
                            return (
                              s > -1
                                ? n.splice(s, 1, { ...e.val(), id: e.key })
                                : n.push({ ...e.val(), id: e.key }),
                              n
                            );
                          });
                        }),
                      firebase
                        .database()
                        .ref(`quizes/${a.id}/users`)
                        .on("child_removed", (e) => {
                          D((t) => {
                            let n = [...t],
                              s = n.findIndex((t) => t.id == e.key);
                            return s > -1 && n.splice(s, 1), n;
                          });
                        }));
                  } else console.log(s);
                  a(!1);
                })
                .catch((e) => {
                  a(!1),
                    console.error("Uh oh, an error!", e),
                    ks("vibebp").addNotification({
                      text: window.wplms_course_data.translations
                        .error_loading_data,
                    });
                });
          },
          F = (e, s, a) => {
            if ("changed" == a) {
              let a = { ...t };
              (a.meta.questions[s] = e),
                n(a),
                Ns(e.marked_answer)
                  ? null == e.marked_answer && localStorage.removeItem(e.id)
                  : "object" == typeof e.marked_answer ||
                    Array.isArray(e.marked_answer)
                  ? localStorage.setItem(e.id, JSON.stringify(e.marked_answer))
                  : localStorage.setItem(e.id, e.marked_answer);
            }
          },
          j = (e, t) => {
            "show" == t && r(e);
          },
          H = () => {
            a("start");
            let s = { ...t };
            if (((s.start = !0), s.remaining && s.remaining > 0)) a(!1), n(s);
            else {
              let t = { quiz_id: s.id, token: b };
              if (
                (e.hasOwnProperty("course") && (t.course = e.course),
                s.hasOwnProperty("non_logged_in_quiz") &&
                  s.non_logged_in_quiz &&
                  (!b || (e.hasOwnProperty("exported") && e.exported)))
              )
                return (
                  a(!1),
                  localStorage.setItem(
                    "quiz_expiry_" + s.id,
                    Math.floor(new Date().getTime() / 1e3) + s.meta.duration
                  ),
                  n(s),
                  void V(s)
                );
              fetch(
                window.wplms_course_data.api_url + "/user/quiz/start?post",
                {
                  method: "POST",
                  headers: window.vibebp.xnonce
                    ? { "X-WP-Nonce": window.vibebp.xnonce }
                    : {},
                  body: JSON.stringify(t),
                }
              )
                .then((e) =>
                  e.ok
                    ? e.json()
                    : {
                        status: 0,
                        message:
                          window.wplms_course_data.translations
                            .error_loading_data,
                      }
                )
                .then((e) => {
                  a(!1), n(s), V(s);
                  let t = `${window.wplms_course_data.api_url}/student/quiz`;
                  W(t),
                    e.hasOwnProperty("message") &&
                      ks("vibebp").addNotification({ text: e.message });
                })
                .catch((e) => {
                  a(!1),
                    console.error("Uh oh, an error!", e),
                    ks("vibebp").addNotification({
                      text: window.wplms_course_data.translations
                        .error_loading_data,
                    });
                });
            }
          },
          R = (s = null, i = null) => {
            z([]),
              localforage.removeItem("bookmarked_questions_" + e.quizid),
              s || (s = t),
              i || Ns(b) || (i = b),
              localStorage.removeItem("quiz_expiry_" + s.id),
              a("submit");
            let r = { ...s },
              o = 0,
              l = 0;
            if (r.meta && r.meta.questions && r.meta.questions.length)
              for (let e = 0; e < r.meta.questions.length; e++)
                r.meta.questions[e].attempted ||
                  (r.meta.questions[e] = Nt(
                    r.meta.questions[e],
                    t.partial_marking,
                    t.negative_marking,
                    parseFloat(t.negative_marks),
                    !1
                  )),
                  (r.meta.questions[e].content =
                    r.meta.questions[e].original_content),
                  r.meta.questions[e].auto ||
                    (r.meta.questions[e].user_marks = 0),
                  (o += parseFloat(r.meta.questions[e].user_marks)),
                  (l += parseInt(r.meta.questions[e].marks)),
                  localStorage.removeItem(r.meta.questions[e].id),
                  localStorage.removeItem(
                    "question_start_time" + r.meta.questions[e].key
                  );
            if (
              ((r.marks = o.toFixed(2)),
              (r.max_marks = l),
              (isNaN(r.max_marks) || r.max_marks < 1) && (r.max_marks = 1),
              (isNaN(r.marks) || r.marks < 1) && (r.marks = 0),
              e.hasOwnProperty("update") &&
                e.update("update_quiz_marks", {
                  user_marks: r.marks,
                  total_marks: r.max_marks,
                }),
              r.hasOwnProperty("remaining") && delete r.remaining,
              e.hasOwnProperty("non_logged_in_quiz") && e.non_logged_in_quiz)
            )
              return (
                (r.submitted = !0),
                (r.start = !1),
                n(r),
                void (e.hasOwnProperty("update") && e.update("quizsubmitted"))
              );
            fetch(
              window.wplms_course_data.api_url + "/user/submitresult?post",
              {
                method: "POST",
                headers: window.vibebp.xnonce
                  ? { "X-WP-Nonce": window.vibebp.xnonce }
                  : {},
                body: JSON.stringify({
                  quiz_id: r.id,
                  course_id: r.hasOwnProperty("course_id")
                    ? r.course_id
                    : e.hasOwnProperty("course")
                    ? e.course
                    : "",
                  results: r.meta.questions,
                  quiz: r,
                  token: i,
                }),
              }
            )
              .then((e) =>
                e.ok
                  ? e.json()
                  : {
                      status: 0,
                      message:
                        window.wplms_course_data.translations
                          .error_loading_data,
                    }
              )
              .then((t) => {
                if (t) {
                  if (
                    (a(!1),
                    (r.submitted = !0),
                    (r.start = !1),
                    t.check_results_url &&
                      (r.check_results_url = t.check_results_url),
                    t.hasOwnProperty("retakes") &&
                      void 0 !== t.retakes &&
                      ((r.hasOwnProperty("meta") && void 0 !== r.meta) ||
                        (r.meta = {}),
                      (r.meta.retakes = t.retakes)),
                    t.completion_message &&
                      (r.meta.completion_message = t.completion_message),
                    t.retake_html && (r.retake_html = t.retake_html),
                    r.meta &&
                      r.meta.questions &&
                      r.meta.questions.length &&
                      !Ns(t.correct_data))
                  )
                    for (let e = 0; e < r.meta.questions.length; e++)
                      t.correct_data.hasOwnProperty(r.meta.questions[e].id) &&
                        (r.meta.questions[e].correct_data =
                          t.correct_data[r.meta.questions[e].id]);
                  t.hasOwnProperty("tags_data") && (r.tags_data = t.tags_data),
                    n(r);
                  var s = document.createEvent("Event");
                  if (
                    (s.initEvent("unit_traverse", !1, !0),
                    r.hasOwnProperty("quiz_passing_score") &&
                    r.quiz_passing_score
                      ? t.hasOwnProperty("continue") &&
                        t.continue &&
                        e.hasOwnProperty("update") &&
                        e.update("quizsubmitted")
                      : e.hasOwnProperty("update") && e.update("quizsubmitted"),
                    document.querySelector(".unit_content") &&
                      document.querySelector(".unit_content"))
                  ) {
                    document.querySelector(".unit_content").dispatchEvent(s);
                    var i = new CustomEvent("react_quiz_submitted", {
                      detail: { next_unit: t.next_unit },
                    });
                    document.dispatchEvent(i);
                  }
                }
                Y(r);
                let o =
                  window.wplms_course_data.api_url +
                  "/user/quiz/previousresults/" +
                  e.quizid;
                W(o, !0);
                let l = `${window.wplms_course_data.api_url}/student/quiz`;
                W(l);
                let u = `${window.wplms_course_data.api_url}/instructor/stats/${e.quizid}`;
                W(u);
                let c = `${window.wplms_course_data.api_url}/instructor/leaderboard/${e.quizid}`;
                W(c),
                  t.hasOwnProperty("message") &&
                    ks("vibebp").addNotification({ text: t.message });
              })
              .catch((e) => {
                a(!1),
                  console.error("Uh oh, an error!", e),
                  ks("vibebp").addNotification({
                    text: window.wplms_course_data.translations
                      .error_loading_data,
                  });
              });
          },
          U = (e, n) => {
            let s = -1;
            switch (
              (t &&
                t.hasOwnProperty("meta") &&
                t.meta &&
                t.meta.hasOwnProperty("questions") &&
                ((s = t.meta.questions.findIndex(
                  (t) => e.hasOwnProperty("key") && t.key === e.key
                )),
                s < 0 && (s = n)),
              e.type)
            ) {
              case "smalltext":
                return _s(ae, { question: e, index: s, update: F });
              case "single":
                return _s(ce, {
                  question: e,
                  index: s,
                  update: F,
                  quiz_id: t.id,
                });
              case "select":
                return _s(we, {
                  question: e,
                  index: s,
                  update: F,
                  quiz_id: t.id,
                });
              case "multiple":
                return _s(ke, {
                  question: e,
                  index: s,
                  update: F,
                  quiz_id: t.id,
                });
              case "fillblank":
                return _s(Le, {
                  question: e,
                  index: s,
                  update: F,
                  quiz_id: t.id,
                });
              case "sort":
                return _s(Xe, {
                  question: e,
                  index: s,
                  update: F,
                  quiz_id: t.id,
                });
              case "match":
                return _s(it, {
                  question: e,
                  index: s,
                  update: F,
                  quiz_id: t.id,
                });
              case "truefalse":
                return _s(dt, {
                  question: e,
                  index: s,
                  update: F,
                  quiz_id: t.id,
                });
              case "largetext":
                return _s(gt, {
                  question: e,
                  index: s,
                  update: F,
                  quiz_id: t.id,
                });
              default:
                let n = 1e3 * Math.random();
                return (
                  document.dispatchEvent(
                    new CustomEvent("wplms_load_question_type", {
                      detail: {
                        question: e,
                        update: F,
                        quiz_id: t.id,
                        index: s,
                        keyref: n,
                      },
                    })
                  ),
                  _s("div", {
                    "data-q": e.id,
                    className: e.type,
                    "data-keyref": n,
                  })
                );
            }
          },
          J = (e, n) => {
            if ("trigger" == n)
              switch (e) {
                case "submit":
                  R(t), w(!1), f(!1);
                  break;
                case "start":
                  H(), _(!1);
              }
            if ("nottrigger" == n)
              switch (e) {
                case "submit":
                  w(!1), f(!1);
                  break;
                case "start":
                  _(!1);
              }
          },
          X = (e, s) => {
            if (
              "expired" == s &&
              e.hasOwnProperty("id") &&
              t?.meta?.questions?.length
            ) {
              let s = { ...t },
                a = s.meta.questions.findIndex((t) => t.key === e.key);
              a > -1 && ((s.meta.questions[a].expired = !0), n(s));
            }
          },
          W = (e, t = null, n = null) =>
            n && !navigator.onLine
              ? new Promise((e, t) => {
                  t(0);
                })
              : "undefined" != typeof localforage &&
                window.vibebp.api.sw_enabled &&
                navigator.onLine
              ? t
                ? localforage.removeItem(e)
                : localforage.iterate(function (t, n, s) {
                    e.length &&
                      n.length &&
                      n.includes(e) &&
                      localforage.removeItem(n);
                  })
              : new Promise((e) => {
                  e(1);
                }),
          Y = (t) => {
            let n = window.wplms_course_data.api_url + "/user/quiz/" + e.quizid;
            e.hasOwnProperty("non_logged_in_quiz") &&
              e.non_logged_in_quiz &&
              !b &&
              (n =
                window.wplms_course_data.api_url +
                "/quiz/nonloggedin/" +
                e.quizid +
                "?client_id=" +
                window.wplms_course_data.client_id),
              "undefined" != typeof localforage &&
                window.vibebp.api.sw_enabled &&
                localforage.getItem(n).then((e) => {
                  e &&
                    e.length &&
                    (e = JSON.parse(e)).hasOwnProperty("meta") &&
                    ((e = t), localforage.setItem(n, JSON.stringify(e)));
                });
          },
          V = (n) => {
            let s = window.wplms_course_data.api_url + "/user/quiz/" + e.quizid;
            e.hasOwnProperty("non_logged_in_quiz") &&
              e.non_logged_in_quiz &&
              !b &&
              (s =
                window.wplms_course_data.api_url +
                "/quiz/nonloggedin/" +
                e.quizid +
                "?client_id=" +
                window.wplms_course_data.client_id),
              "undefined" != typeof localforage &&
                window.vibebp.api.sw_enabled &&
                localforage.getItem(s).then((e) => {
                  e &&
                    e.length &&
                    (e = JSON.parse(e)).hasOwnProperty("meta") &&
                    ((n.expiry =
                      Math.round(new Date().getTime() / 1e3) +
                      parseInt(t.meta.duration)),
                    (e = n),
                    localforage.setItem(s, JSON.stringify(e)));
                });
          };
        let Q = 0;
        t.meta && t.meta.duration && (Q = t.meta.duration),
          t && t.remaining && t.remaining > 0 && (Q = t.remaining),
          t.hasOwnProperty("end_time") &&
            parseInt(t.end_time) &&
            parseInt(t.end_time) > new Date().getTime() &&
            (parseInt(t.end_time) - new Date().getTime()) / 1e3 < Q &&
            (Q = Math.floor(
              (parseInt(t.end_time) - new Date().getTime()) / 1e3
            ));
        let K = "",
          G = "loading_quiz";
        s || ((K = "disabled"), (G += " disabled"));
        let Z = window.wplms_course_data.translations.submit_quiz_confirm;
        if (t.meta && t.meta.questions) {
          let e = 1;
          t.meta.questions.map(function (t) {
            t.marked_answer || (e = 0);
          }),
            e ||
              (Z =
                window.wplms_course_data.translations.unanswered_confirm + Z);
        }
        let ee = [];
        if (
          (t.hasOwnProperty("meta") &&
            t.meta.hasOwnProperty("questions") &&
            t.meta.questions &&
            t.meta.questions.length &&
            (ee = [...t.meta.questions]),
          ee.length && null !== q)
        )
          switch (q) {
            case "wrong":
              ee = ee.filter(
                (e) =>
                  !e.hasOwnProperty("user_marks") ||
                  !e.user_marks ||
                  parseFloat(e.user_marks) <= 0
              );
              break;
            case "correct":
              ee = ee.filter(
                (e) =>
                  e.hasOwnProperty("user_marks") &&
                  e.user_marks &&
                  parseFloat(e.user_marks) > 0
              );
              break;
            case "bookmarked":
              ee = ee.filter((e) => N.indexOf(e.id) > -1);
          }
        return "quiz" !== s
          ? t && t.hasOwnProperty("drip_message")
            ? _s(
                ys,
                null,
                t && t.hasOwnProperty("drip_time")
                  ? _s(Dn, {
                      start: !0,
                      duration: t.drip_time,
                      update: (e, t) => {
                        "expired" == t && $(null, !0);
                      },
                      quiz_id: t.id,
                    })
                  : "",
                _s("div", {
                  className: "quiz_content",
                  dangerouslySetInnerHTML: {
                    __html:
                      t && t.hasOwnProperty("drip_message")
                        ? t.drip_message
                        : "",
                  },
                })
              )
            : _s(
                ys,
                null,
                _s(un, {
                  active: h,
                  update: J,
                  type: "submit",
                  content: Z,
                  yes: window.wplms_course_data.translations.yes,
                  no: window.wplms_course_data.translations.no,
                  yesfunction: "submitQuiz",
                }),
                ReactDOM.createPortal(
                  _s(un, {
                    active: g,
                    update: J,
                    type: "submit",
                    content:
                      window.wplms_course_data.translations.bookmark_confirm,
                    yes: window.wplms_course_data.translations.yes,
                    no: window.wplms_course_data.translations.no,
                    yesfunction: "submitQuiz",
                  }),
                  document.querySelector("#quiz_popup")
                ),
                E
                  ? ReactDOM.createPortal(
                      _s(
                        "div",
                        { className: "confirmpopup_wrapper" },
                        _s(
                          "div",
                          { className: "confirmpopup_content" },
                          _s("textarea", {
                            value: E.flagged_feedback,
                            onChange: (e) => {
                              let s = { ...t },
                                a = s.meta.questions.findIndex(
                                  (e) => parseInt(E.id) === parseInt(e.id)
                                );
                              if (a > -1) {
                                (s.meta.questions[a].flagged_feedback =
                                  e.target.value),
                                  n(s);
                                let t = { ...E };
                                (t.flagged_feedback =
                                  s.meta.questions[a].flagged_feedback),
                                  P(t);
                              }
                            },
                          }),
                          _s(
                            "div",
                            { className: "buttons_wrapper" },
                            _s(
                              "span",
                              {
                                className:
                                  O.indexOf(E.id) > -1
                                    ? "button is-loading"
                                    : E.flagged
                                    ? "button flagged"
                                    : "button flag",
                                onClick: (e) => {
                                  (() => {
                                    let e = E,
                                      s = t.meta.questions.findIndex(
                                        (e) => parseInt(E.id) === parseInt(e.id)
                                      );
                                    if (s > -1) {
                                      if (Ns(e.flagged_feedback))
                                        return (
                                          ks("vibebp").addNotification({
                                            text: window.wplms_course_data
                                              .translations
                                              .add_feedback_to_flag,
                                          }),
                                          !1
                                        );
                                      let a = [...O];
                                      a.indexOf(e.id) <= -1 && a.push(e.id),
                                        S(a),
                                        fetch(
                                          window.wplms_course_data.api_url +
                                            "/user/question/flag/" +
                                            e.id +
                                            "?post",
                                          {
                                            method: "post",
                                            headers: window.vibebp.xnonce
                                              ? {
                                                  "X-WP-Nonce":
                                                    window.vibebp.xnonce,
                                                }
                                              : {},
                                            body: JSON.stringify({
                                              token: b,
                                              flagged: !0,
                                              feedback: e.flagged_feedback,
                                            }),
                                          }
                                        )
                                          .then((e) =>
                                            e.ok
                                              ? e.json()
                                              : {
                                                  status: 0,
                                                  message:
                                                    window.wplms_course_data
                                                      .translations
                                                      .error_loading_data,
                                                }
                                          )
                                          .then((i) => {
                                            if (i) {
                                              if (i.status) {
                                                let i = a.indexOf(e.id);
                                                i > -1 &&
                                                  (a.splice(i, 1), S(a));
                                                let r = { ...t };
                                                (r.meta.questions[s].flagged =
                                                  !0),
                                                  n(r),
                                                  C(""),
                                                  P(!1);
                                              }
                                              i.message &&
                                                ks("vibebp").addNotification({
                                                  icon: "",
                                                  text: i.message,
                                                });
                                            }
                                          })
                                          .catch((e) => {
                                            console.error(
                                              "Uh oh, an error!",
                                              e
                                            ),
                                              ks("vibebp").addNotification({
                                                text: window.wplms_course_data
                                                  .translations
                                                  .error_loading_data,
                                              });
                                          });
                                    }
                                  })();
                                },
                              },
                              window.wplms_course_data.translations
                                .submit_feedback
                            ),
                            _s(
                              "span",
                              {
                                className: "button",
                                onClick: (e) => {
                                  P(!1);
                                },
                              },
                              window.wplms_course_data.translations.cancel
                            )
                          )
                        )
                      ),
                      document.querySelector("#quiz_popup")
                    )
                  : "",
                _s(un, {
                  active: p,
                  update: J,
                  type: "start",
                  content:
                    window.wplms_course_data.translations.start_quiz_confirm,
                  yes: window.wplms_course_data.translations.yes,
                  no: window.wplms_course_data.translations.no,
                  yesfunction: "startQuiz",
                }),
                _s(
                  "div",
                  {
                    className:
                      "incourse " + (A.length ? "leaderboard_contest" : ""),
                  },
                  _s(
                    "div",
                    { className: G },
                    _s("div", { id: "ajaxloader", className: K })
                  ),
                  e.hasOwnProperty("activity")
                    ? t.submitted
                      ? _s(
                          "h3",
                          null,
                          _s(
                            "span",
                            { className: "student_score" },
                            t.meta.auto ? t.marks + "/" + t.max_marks : ""
                          ),
                          t.quiz_passing_score
                            ? _s(
                                "span",
                                null,
                                t.marks > t.quiz_passing_score
                                  ? window.wplms_course_data.translations.passed
                                  : window.wplms_course_data.translations.failed
                              )
                            : ""
                        )
                      : ""
                    : _s(
                        "div",
                        {
                          className:
                            "up" == c
                              ? "incoursequiz_details show_controls"
                              : "incoursequiz_details hide_controls",
                          ref: o,
                        },
                        _s(
                          "div",
                          { className: "quiz_first_block" },
                          t.submitted
                            ? _s(
                                "strong",
                                null,
                                _s(
                                  "span",
                                  { className: "student_score" },
                                  t.meta.auto ? t.marks + "/" + t.max_marks : ""
                                ),
                                t.quiz_passing_score
                                  ? _s(
                                      "span",
                                      null,
                                      t.marks > t.quiz_passing_score
                                        ? window.wplms_course_data.translations
                                            .passed
                                        : window.wplms_course_data.translations
                                            .failed
                                    )
                                  : "",
                                _s(
                                  "span",
                                  { className: "student_quiz_status" },
                                  window.wplms_course_data.translations
                                    .quiz_submitted
                                )
                              )
                            : _s(
                                "div",
                                { className: "quiztimer_wrapper" },
                                t.hasOwnProperty("end_time") &&
                                  parseInt(t.end_time)
                                  ? _s(
                                      "div",
                                      { className: "end_timer" },
                                      _s(
                                        "span",
                                        null,
                                        window.wplms_course_data.translations
                                          .ends_in
                                      ),
                                      _s(B, {
                                        duration: Math.floor(
                                          (t.end_time - new Date().getTime()) /
                                            1e3
                                        ),
                                        update: () => {},
                                        quiz_id: t.id,
                                        start: !0,
                                      })
                                    )
                                  : "",
                                t &&
                                  t.meta &&
                                  t.meta.duration &&
                                  parseInt(t.meta.duration) < 863913600
                                  ? _s(B, {
                                      duration: Q,
                                      update: (e, n) => {
                                        "expired" == n &&
                                          "submit" !== !s &&
                                          R(t);
                                      },
                                      quiz_id: t.id,
                                      start: t.start,
                                    })
                                  : _s(
                                      "strong",
                                      null,
                                      window.wplms_course_data.translations
                                        .no_time_limit
                                    )
                              ),
                          t &&
                            t.meta &&
                            t.meta.questions &&
                            t.meta.questions.length &&
                            t.submitted
                            ? _s(
                                "div",
                                { className: "buttons has-addons small" },
                                _s(
                                  "a",
                                  {
                                    className:
                                      "correct" == q
                                        ? "button tip end is-focused"
                                        : "button tip",
                                    title:
                                      window.wplms_course_data.translations
                                        .show_correct_attempts,
                                    onClick: () => {
                                      x("correct" != q ? "correct" : null);
                                    },
                                  },
                                  _s("span", { className: "vicon vicon-check" })
                                ),
                                _s(
                                  "a",
                                  {
                                    className:
                                      "wrong" == q
                                        ? "button tip end is-focused"
                                        : "button tip",
                                    title:
                                      window.wplms_course_data.translations
                                        .show_wrong_attempts,
                                    onClick: () => {
                                      x("wrong" != q ? "wrong" : null);
                                    },
                                  },
                                  _s("span", { className: "vicon vicon-close" })
                                ),
                                t.hasOwnProperty("show_print_results") &&
                                  t.show_print_results
                                  ? _s(
                                      "a",
                                      {
                                        className: "button tip",
                                        title:
                                          window.wplms_course_data.translations
                                            .print_results,
                                        onClick: () => {
                                          (async () => {
                                            if (!t.meta.questions.length)
                                              return !1;
                                            void 0 === e.quizid &&
                                              (e.quizid = e.quiz.id),
                                              document.getElementById(
                                                "quiz_results_" + e.quizid
                                              ) &&
                                                document
                                                  .getElementById(
                                                    "quiz_results_" + e.quizid
                                                  )
                                                  .remove();
                                            const n =
                                              document.createElement("div");
                                            if (
                                              ((n.src = n.src),
                                              n.setAttribute(
                                                "id",
                                                "quiz_results_" + e.quizid
                                              ),
                                              n.classList.add("quiz_results"),
                                              t.hasOwnProperty("title"))
                                            ) {
                                              let e =
                                                  document.createElement(
                                                    "meta"
                                                  ),
                                                n =
                                                  document.createElement(
                                                    "meta"
                                                  );
                                              e.setAttribute(
                                                "property",
                                                "og:title"
                                              );
                                              let s = "";
                                              t.meta.auto &&
                                                (s =
                                                  t.marks + "/" + t.max_marks),
                                                t.quiz_passing_score &&
                                                  (t.marks >
                                                  t.quiz_passing_score
                                                    ? (s +=
                                                        " " +
                                                        window.wplms_course_data
                                                          .translations.passed)
                                                    : (s +=
                                                        " " +
                                                        window.wplms_course_data
                                                          .translations
                                                          .failed)),
                                                e.setAttribute(
                                                  "content",
                                                  s + t.title
                                                ),
                                                e.setAttribute(
                                                  "name",
                                                  "twitter:title"
                                                ),
                                                e.setAttribute(
                                                  "content",
                                                  s + t.title
                                                ),
                                                document.body.appendChild(e),
                                                document.body.appendChild(n);
                                            }
                                            document.body.appendChild(n),
                                              hs(
                                                _s(Pn, {
                                                  quiz: t,
                                                  renderSwitch: U,
                                                }),
                                                document.getElementById(
                                                  "quiz_results_" + e.quizid
                                                )
                                              ),
                                              await new Promise((e) =>
                                                setTimeout(e, 1e3)
                                              );
                                            let s = document.getElementById(
                                              "quiz_results_" + e.quizid
                                            ).outerHTML;
                                            document.getElementById(
                                              "quiz_results_" + e.quizid
                                            ) &&
                                              document
                                                .getElementById(
                                                  "quiz_results_" + e.quizid
                                                )
                                                .remove();
                                            var a = window.open(
                                              "",
                                              "",
                                              "height=800, width=1000"
                                            );
                                            a.document.write(s), a.print();
                                          })();
                                        },
                                      },
                                      _s("span", {
                                        className: "vicon vicon-printer",
                                      })
                                    )
                                  : ""
                              )
                            : "",
                          t &&
                            t.meta &&
                            t.meta.questions &&
                            t.meta.questions.length &&
                            N.length
                            ? _s(
                                "div",
                                { className: "buttons has-addons" },
                                _s(
                                  "a",
                                  {
                                    className:
                                      "bookmarked" == q
                                        ? "button tip end is-focused"
                                        : "button tip",
                                    title:
                                      window.wplms_course_data.translations
                                        .show_bookmarked,
                                    onClick: () => {
                                      x(
                                        "bookmarked" != q ? "bookmarked" : null
                                      );
                                    },
                                  },
                                  _s("span", {
                                    className: "vicon vicon-bookmark-alt",
                                  })
                                )
                              )
                            : "",
                          _s(
                            "span",
                            "up" == c
                              ? {
                                  className:
                                    "quiz_detail_toggle vicon button is-primary vicon-arrow-up",
                                  onClick: () => {
                                    m("up" == c ? "down" : "up");
                                  },
                                }
                              : {
                                  className:
                                    "quiz_detail_toggle vicon button is-primary vicon-arrow-down",
                                  onClick: () => {
                                    m("up" == c ? "down" : "up");
                                  },
                                }
                          )
                        ),
                        _s(
                          "div",
                          { className: "quiz_timeline" },
                          !t.submitted || (t.meta && t.meta.retakes > 0)
                            ? _s(
                                "div",
                                { className: "incourse_quiz_button" },
                                t.start || t.submitted
                                  ? ""
                                  : t.remaining && t.remaining > 0
                                  ? _s(
                                      "a",
                                      {
                                        className:
                                          "continue_quiz button is-primary",
                                        onClick: H,
                                      },
                                      window.wplms_course_data.translations
                                        .continue
                                    )
                                  : t &&
                                    t.meta &&
                                    t.meta.hasOwnProperty("check_access") &&
                                    "object" == typeof t.meta.check_access &&
                                    t.meta.check_access.hasOwnProperty(
                                      "status"
                                    ) &&
                                    !t.meta.check_access.status
                                  ? _s("div", {
                                      className: "check_quiz",
                                      dangerouslySetInnerHTML: {
                                        __html: t.meta.check_access.html,
                                      },
                                    })
                                  : t.hasOwnProperty("end_time") &&
                                    parseInt(t.end_time) &&
                                    parseInt(t.end_time) <= new Date().getTime()
                                  ? ""
                                  : t.hasOwnProperty("start_time") &&
                                    t.start_time &&
                                    parseInt(t.start_time) >
                                      new Date().getTime()
                                  ? _s(
                                      "div",
                                      { className: "start_timer" },
                                      _s(
                                        "div",
                                        null,
                                        window.wplms_course_data.translations
                                          .starts_in
                                      ),
                                      _s(B, {
                                        duration: Math.floor(
                                          (parseInt(t.start_time) -
                                            new Date().getTime()) /
                                            1e3
                                        ),
                                        update: () => {
                                          n({ ...t, start_time: t.start_time });
                                        },
                                        quiz_id: t.id,
                                        start: !0,
                                      })
                                    )
                                  : _s(
                                      "a",
                                      {
                                        className:
                                          "start" === s
                                            ? "start_quiz button full is-primary is-loading"
                                            : "start_quiz  full button is-primary",
                                        onClick: () => {
                                          window.wplms_course_data.start_popup
                                            ? _(!0)
                                            : H();
                                        },
                                      },
                                      window.wplms_course_data.translations
                                        .start
                                    ),
                                !t.start ||
                                  t.submitted ||
                                  (e.hasOwnProperty("non_logged_in_quiz") &&
                                    (!e.hasOwnProperty("non_logged_in_quiz") ||
                                      e.non_logged_in_quiz))
                                  ? ""
                                  : _s(
                                      "a",
                                      {
                                        className:
                                          "save" === s
                                            ? "save_quiz button is-primary is-loading"
                                            : "save_quiz button is-primary",
                                        onClick: () => {
                                          if (
                                            t.meta.questions &&
                                            t.meta.questions.length
                                          ) {
                                            a("save");
                                            let e = [];
                                            t.meta.questions.map((t, n) => {
                                              let s = { ...t };
                                              null == s.marked_answer ||
                                                "undefined" ==
                                                  s.marked_answer ||
                                                Ns(s.marked_answer) ||
                                                t.attempted ||
                                                ((s.correct = qt(s)),
                                                e.push(s));
                                            }),
                                              fetch(
                                                window.wplms_course_data
                                                  .api_url +
                                                  "/user/savequiz?post",
                                                {
                                                  method: "POST",
                                                  headers: window.vibebp.xnonce
                                                    ? {
                                                        "X-WP-Nonce":
                                                          window.vibebp.xnonce,
                                                      }
                                                    : {},
                                                  body: JSON.stringify({
                                                    quiz_id: t.id,
                                                    questions: e,
                                                    token: b,
                                                  }),
                                                }
                                              )
                                                .then((e) =>
                                                  e.ok
                                                    ? e.json()
                                                    : {
                                                        status: 0,
                                                        message:
                                                          window
                                                            .wplms_course_data
                                                            .translations
                                                            .error_loading_data,
                                                      }
                                                )
                                                .then((e) => {
                                                  a(!1),
                                                    e.hasOwnProperty(
                                                      "message"
                                                    ) &&
                                                      ks(
                                                        "vibebp"
                                                      ).addNotification({
                                                        text: e.message,
                                                      });
                                                })
                                                .catch((e) => {
                                                  a(!1),
                                                    console.error(
                                                      "Uh oh, an error!",
                                                      e
                                                    ),
                                                    ks(
                                                      "vibebp"
                                                    ).addNotification({
                                                      text: window
                                                        .wplms_course_data
                                                        .translations
                                                        .error_loading_data,
                                                    });
                                                });
                                          }
                                        },
                                      },
                                      window.wplms_course_data.translations
                                        .save_quiz
                                    ),
                                (t.hasOwnProperty("end_time") &&
                                  parseInt(t.end_time) &&
                                  parseInt(t.end_time) <=
                                    new Date().getTime()) ||
                                  !t.start ||
                                  t.submitted ||
                                  (t &&
                                    t.hasOwnProperty("hide_submit_button") &&
                                    t.hide_submit_button &&
                                    i &&
                                    i.length &&
                                    t.hasOwnProperty("meta") &&
                                    t.meta &&
                                    t.meta.hasOwnProperty("questions") &&
                                    t.meta.questions &&
                                    t.meta.questions.length &&
                                    !(
                                      i.indexOf(t.meta.questions.length - 1) >
                                      -1
                                    ))
                                  ? ""
                                  : _s(
                                      "a",
                                      {
                                        className:
                                          "submit" === s
                                            ? "submit_quiz button is-primary is-loading"
                                            : "submit_quiz button is-primary",
                                        onClick: () => {
                                          window.wplms_course_data.submit_popup
                                            ? w(!0)
                                            : N.length
                                            ? f(!0)
                                            : R();
                                        },
                                      },
                                      window.wplms_course_data.translations
                                        .submit
                                    ),
                                !t.start &&
                                  t.submitted &&
                                  t.meta &&
                                  t.meta.retakes > 0
                                  ? _s(
                                      "div",
                                      { className: "quiz_retake" },
                                      _s(
                                        "a",
                                        {
                                          className:
                                            "retake" === s
                                              ? "retake_quiz button is-primary is-loading"
                                              : "retake_quiz button is-primary",
                                          onClick: () =>
                                            (() => {
                                              t.hasOwnProperty(
                                                "non_logged_in_quiz"
                                              ) &&
                                                t.non_logged_in_quiz &&
                                                !b &&
                                                localStorage.removeItem(
                                                  "vibequiz_" + t.id
                                                ),
                                                a("retake");
                                              let n = { token: b };
                                              if (
                                                (e.hasOwnProperty("course") &&
                                                  (n.course = e.course),
                                                e.hasOwnProperty(
                                                  "non_logged_in_quiz"
                                                ) && e.non_logged_in_quiz)
                                              ) {
                                                localStorage.removeItem(
                                                  "vibequiz_" + e.quizid
                                                );
                                                let n = localStorage.getItem(
                                                  "quiz_retakes_" + e.quizid
                                                );
                                                return (
                                                  n || (n = 0),
                                                  localStorage.setItem(
                                                    "quiz_retakes_" + t.id,
                                                    parseInt(n) + 1
                                                  ),
                                                  void $()
                                                );
                                              }
                                              let s =
                                                window.wplms_course_data
                                                  .api_url +
                                                "/user/quiz/" +
                                                e.quizid;
                                              e.hasOwnProperty(
                                                "non_logged_in_quiz"
                                              ) &&
                                                e.non_logged_in_quiz &&
                                                !b &&
                                                (s =
                                                  window.wplms_course_data
                                                    .api_url +
                                                  "/quiz/nonloggedin/" +
                                                  e.quizid +
                                                  "?client_id=" +
                                                  window.wplms_course_data
                                                    .client_id),
                                                W(s, !0, !0)
                                                  .then((t) => {
                                                    fetch(
                                                      window.wplms_course_data
                                                        .api_url +
                                                        "/user/coursestatus/retake_single_quiz/" +
                                                        e.quizid +
                                                        "?post",
                                                      {
                                                        method: "post",
                                                        headers: window.vibebp
                                                          .xnonce
                                                          ? {
                                                              "X-WP-Nonce":
                                                                window.vibebp
                                                                  .xnonce,
                                                            }
                                                          : {},
                                                        body: JSON.stringify(n),
                                                      }
                                                    )
                                                      .then((e) => e.json())
                                                      .then((t) => {
                                                        if (t)
                                                          if (t.status) {
                                                            if (
                                                              ($(),
                                                              e.hasOwnProperty(
                                                                "update"
                                                              ) &&
                                                                e.update(
                                                                  "retake_quiz"
                                                                ),
                                                              firebase &&
                                                                firebase.database &&
                                                                firebase.auth()
                                                                  .currentUser)
                                                            ) {
                                                              let t = M;
                                                              (t &&
                                                                t.hasOwnProperty(
                                                                  "id"
                                                                )) ||
                                                                (t =
                                                                  qs(
                                                                    "vibebp"
                                                                  ).getUser()),
                                                                firebase
                                                                  .database()
                                                                  .ref(
                                                                    `quizes/${e.quizid}/users/${t.id}`
                                                                  )
                                                                  .remove();
                                                            }
                                                          } else
                                                            t.message &&
                                                              (ks(
                                                                "vibebp"
                                                              ).addNotification(
                                                                {
                                                                  icon: "",
                                                                  text: t.message,
                                                                }
                                                              ),
                                                              a(!1));
                                                      });
                                                  })
                                                  .catch((e) => {
                                                    console.log(e),
                                                      navigator &&
                                                        !navigator.onLine &&
                                                        (ks(
                                                          "vibebp"
                                                        ).addNotification({
                                                          text: window
                                                            .wplms_course_data
                                                            .translations
                                                            .could_not_retake_offline,
                                                        }),
                                                        a(!1));
                                                  });
                                            })(),
                                        },
                                        window.wplms_course_data.translations
                                          .retake
                                      ),
                                      _s(
                                        "strong",
                                        null,
                                        window.wplms_course_data.translations
                                          .retakes_left,
                                        " : ",
                                        t.meta.retakes
                                      )
                                    )
                                  : ""
                              )
                            : "",
                          v
                            ? _s(Ut, {
                                hideQuestions: () => y(!1),
                                quiz: t,
                                currentQuestions: i,
                                update: j,
                                filter: q,
                                bookMarked: N,
                              })
                            : "",
                          t &&
                            t.meta &&
                            t.meta.questions &&
                            t.meta.questions.length &&
                            !v
                            ? _s(
                                "span",
                                {
                                  className: "show_questions",
                                  onClick: () => y(!0),
                                },
                                _s(
                                  "span",
                                  null,
                                  window.wplms_course_data.translations
                                    .show_questions
                                ),
                                _s("span", {
                                  className: "vicon vicon-angle-double-right",
                                })
                              )
                            : "",
                          "live_contest" == t.quiz_type
                            ? _s(is, { leaderboardData: A, quiz: t })
                            : ""
                        )
                      ),
                  _s(
                    "div",
                    { className: "quiz_questions_content" },
                    _s(
                      "div",
                      { className: "" },
                      t.start || t.submitted
                        ? ""
                        : _s("div", {
                            className: "quiz_content",
                            dangerouslySetInnerHTML: {
                              __html: t && t.content ? t.content : "",
                            },
                          }),
                      !t.start && t.submitted
                        ? _s(
                            "div",
                            { className: "" },
                            _s("div", {
                              className: "quiz_content",
                              dangerouslySetInnerHTML: {
                                __html: t.meta.completion_message,
                              },
                            }),
                            !t.start && t.submitted && t.retake_html
                              ? _s("div", {
                                  dangerouslySetInnerHTML: {
                                    __html: t.retake_html,
                                  },
                                })
                              : ""
                          )
                        : "",
                      t.start || !t.submitted || e.hasOwnProperty("activity")
                        ? ""
                        : !e.hasOwnProperty("non_logged_in_quiz") ||
                          (e.hasOwnProperty("non_logged_in_quiz") &&
                            !e.non_logged_in_quiz)
                        ? _s(xn, { quizid: e.quizid })
                        : "",
                      t &&
                        t.meta &&
                        t.meta.questions &&
                        t.submitted &&
                        t.meta.auto &&
                        t.show_advance_stats &&
                        !e.hasOwnProperty("activity")
                        ? _s(wn, { quiz: t })
                        : "",
                      t && t.meta && ee && (t.start || t.submitted)
                        ? ee.map((r, o) => {
                            if (-1 === i.indexOf(o)) return;
                            let l = "",
                              u = "";
                            r.hasOwnProperty("show_hint") && r.show_hint
                              ? ((u = "question_hint_content message show"),
                                (l = "question_hint show"))
                              : ((u = "question_hint_content message"),
                                (l = "question_hint"));
                            let c = 0;
                            if (
                              "submit" !== s &&
                              (!t.hasOwnProperty("submitted") ||
                                !t.submitted) &&
                              r.hasOwnProperty("question_duration") &&
                              r.question_duration
                            ) {
                              c = parseInt(r.question_duration);
                              let e = localStorage.getItem(
                                "question_start_time" + r.key
                              );
                              if (e) {
                                let t = (new Date().getTime() - e) / 1e3;
                                c = t < c ? Math.floor(c - t) : 0;
                              } else
                                (e = 0),
                                  localStorage.setItem(
                                    "question_start_time" + r.key,
                                    new Date().getTime()
                                  );
                            }
                            return _s(
                              "div",
                              { className: "question" },
                              _s(
                                "div",
                                { className: "question_actions" },
                                _s(
                                  "span",
                                  null,
                                  window.wplms_course_data.translations
                                    .question_full_prefix,
                                  " ",
                                  o + 1
                                ),
                                _s(
                                  "div",
                                  null,
                                  _s(
                                    "span",
                                    { className: "marks" },
                                    _s("i", {
                                      className: "vicon vicon-medall",
                                    }),
                                    r.marks
                                  ),
                                  !e.hasOwnProperty("non_logged_in_quiz") ||
                                    (e.hasOwnProperty("non_logged_in_quiz") &&
                                      !e.non_logged_in_quiz)
                                    ? _s(
                                        "span",
                                        {
                                          className:
                                            O.indexOf(r.id) > -1
                                              ? "is-loading"
                                              : r.flagged
                                              ? "flagged"
                                              : "flag",
                                          onClick: () => {
                                            P(r);
                                          },
                                        },
                                        _s("i", {
                                          className: r.flagged
                                            ? "vicon vicon-flag-alt"
                                            : "vicon vicon-flag",
                                        })
                                      )
                                    : "",
                                  r.hint
                                    ? _s("span", {
                                        className: l,
                                        onClick: (e) => {
                                          let s = { ...t };
                                          s.meta.questions[o].hasOwnProperty(
                                            "show_hint"
                                          ) && s.meta.questions[o].show_hint
                                            ? (s.meta.questions[o].show_hint =
                                                !1)
                                            : (s.meta.questions[o].show_hint =
                                                !0),
                                            n(s);
                                        },
                                      })
                                    : ""
                                )
                              ),
                              "submit" === s ||
                                (t.hasOwnProperty("submitted") &&
                                  t.submitted) ||
                                !r.hasOwnProperty("question_duration") ||
                                !r.question_duration
                                ? ""
                                : _s(T, {
                                    question: { ...r },
                                    update: X,
                                    duration: c,
                                    start: !0,
                                  }),
                              U(r, o),
                              !t.submitted && t.start
                                ? _s(
                                    "span",
                                    {
                                      className: "bookmark button",
                                      onClick: () => {
                                        ((t) => {
                                          let n = [...N],
                                            s = n.indexOf(t.id);
                                          s <= -1
                                            ? n.push(t.id)
                                            : n.splice(s, 1),
                                            localforage.setItem(
                                              "bookmarked_questions_" +
                                                e.quizid,
                                              JSON.stringify(n)
                                            ),
                                            z(n),
                                            n.length ||
                                              "bookmarked" != q ||
                                              x(null);
                                        })(r);
                                      },
                                    },
                                    _s("i", {
                                      className:
                                        N.indexOf(r.id) > -1
                                          ? "vicon vicon-bookmark-alt"
                                          : "vicon vicon-bookmark",
                                    })
                                  )
                                : "",
                              r.attempted || !t.check_answer || t.submitted
                                ? ""
                                : !e.hasOwnProperty("non_logged_in_quiz") ||
                                  (e.hasOwnProperty("non_logged_in_quiz") &&
                                    !e.non_logged_in_quiz)
                                ? _s(
                                    "div",
                                    {
                                      className:
                                        "checkanswer" === s
                                          ? "check_answer button is-primary is-loading"
                                          : "check_answer button is-primary",
                                      onClick: (e) => {
                                        ((e, s) => {
                                          a("checkanswer");
                                          let i = Nt(
                                              e,
                                              t.partial_marking,
                                              t.negative_marking,
                                              parseFloat(t.negative_marks),
                                              !0
                                            ),
                                            r = { ...t };
                                          (i.attempted = !0),
                                            i.hasOwnProperty("marked_answer") ||
                                              (i.marked_answer = ""),
                                            (r.meta.questions[s] = i),
                                            fetch(
                                              window.wplms_course_data.api_url +
                                                "/user/saveuserquestion?post",
                                              {
                                                method: "POST",
                                                headers: window.vibebp.xnonce
                                                  ? {
                                                      "X-WP-Nonce":
                                                        window.vibebp.xnonce,
                                                    }
                                                  : {},
                                                body: JSON.stringify({
                                                  quiz_id: r.id,
                                                  question: i,
                                                  token: b,
                                                }),
                                              }
                                            )
                                              .then((e) =>
                                                e.ok
                                                  ? e.json()
                                                  : {
                                                      status: 0,
                                                      message:
                                                        window.wplms_course_data
                                                          .translations
                                                          .error_loading_data,
                                                    }
                                              )
                                              .then((e) => {
                                                if (
                                                  (a(!1),
                                                  n(r),
                                                  Y(r),
                                                  "live_contest" ==
                                                    r.quiz_type && firebase)
                                                ) {
                                                  let e = 0,
                                                    t = 0;
                                                  if (
                                                    (r.meta.questions.map(
                                                      (n) => {
                                                        n.attempted && e++,
                                                          n.hasOwnProperty(
                                                            "user_marks"
                                                          ) &&
                                                            (t += n.user_marks);
                                                      }
                                                    ),
                                                    firebase &&
                                                      firebase.auth() &&
                                                      firebase.auth()
                                                        .currentUser)
                                                  ) {
                                                    let n = M;
                                                    (n &&
                                                      n.hasOwnProperty("id")) ||
                                                      (n =
                                                        qs("vibebp").getUser()),
                                                      firebase
                                                        .database()
                                                        .ref(
                                                          `quizes/${r.id}/users/${n.id}/attempted`
                                                        )
                                                        .set(e, (e) => {
                                                          e && console.log(e);
                                                        }),
                                                      firebase
                                                        .database()
                                                        .ref(
                                                          `quizes/${r.id}/users/${n.id}/marks`
                                                        )
                                                        .set(
                                                          parseFloat(t),
                                                          (e) => {
                                                            e && console.log(e);
                                                          }
                                                        );
                                                  }
                                                }
                                              })
                                              .catch((e) => {
                                                a(!1),
                                                  console.error(
                                                    "Uh oh, an error!",
                                                    e
                                                  ),
                                                  ks("vibebp").addNotification({
                                                    text: window
                                                      .wplms_course_data
                                                      .translations
                                                      .error_loading_data,
                                                  });
                                              });
                                        })(r, o);
                                      },
                                    },
                                    window.wplms_course_data.translations
                                      .check_answer
                                  )
                                : "",
                              r.hint
                                ? _s("span", {
                                    className: u,
                                    dangerouslySetInnerHTML: { __html: r.hint },
                                  })
                                : "",
                              r.attempted ? _s(Ct, { question: r }) : "",
                              r.attempted &&
                                r.show_correct_answer &&
                                r.explanation.length
                                ? _s(
                                    "div",
                                    { className: "explanation" },
                                    _s(
                                      "strong",
                                      null,
                                      window.wplms_course_data.translations
                                        .question_explanation
                                    ),
                                    _s("div", {
                                      dangerouslySetInnerHTML: {
                                        __html: r.explanation,
                                      },
                                    })
                                  )
                                : ""
                            );
                          })
                        : "",
                      t &&
                        t.meta &&
                        t.meta.questions &&
                        (t.start || t.submitted)
                        ? _s(tn, {
                            quiz: t,
                            questions: [...ee],
                            currentQuestions: i,
                            filter: q,
                            update: j,
                            bookMarked: N,
                          })
                        : ""
                    )
                  )
                )
              )
          : _s(d, null);
      };
      var Ss = n(299),
        Es = n.n(Ss);
      const {
          createElement: Ps,
          useState: Is,
          useEffect: Cs,
          useRef: Ms,
          Fragment: Ls,
          render: Ts,
        } = wp.element,
        { dispatch: As, select: Ds } = wp.data,
        $s = Math.round(100 * Math.random()),
        Fs = (e) => {
          const t = Ms(null),
            [n, s] = Is(!1),
            [a, i] = Is(!1),
            [r, o] = Is(""),
            [l, u] = Is(""),
            [c, d] = Is(""),
            [m, p] = Is(""),
            [_, h] = Is({ x: 0, y: 0, width: 0, height: 0, type: "image" }),
            [w, g] = Is(""),
            [f, v] = Is(window.wplms_course_data.translations.select_image);
          return (
            Cs(() => {
              e.hasOwnProperty("crop") && e.crop && s(!0);
            }, []),
            Cs(() => {
              a &&
                w &&
                n &&
                new (Es())(w, {
                  returnMode: "ratio",
                  onCropEnd: function (t) {
                    let n = { ..._ };
                    (n.x = 100 * t.x),
                      (n.y = 100 * t.y),
                      (n.height = 100 * t.height),
                      (n.width = 100 * t.width),
                      h(n);
                    let s = {
                      x: w.naturalWidth * t.x,
                      y: w.naturalHeight * t.y,
                      width: w.naturalWidth * t.width,
                      height: w.naturalHeight * t.height,
                    };
                    e.update(m, s);
                  },
                });
            }, [a, w]),
            _.x,
            _.y,
            _.width,
            _.height,
            Ps(
              "div",
              { className: "uploader" },
              Ps(
                "label",
                { for: "fileupload_" + $s, className: "upload_file" },
                f,
                "image" == e.type
                  ? Ps("input", {
                      id: "fileupload_" + $s,
                      "data-type": e.type,
                      ref: t,
                      type: "file",
                      accept: "image/*",
                      onChange: (n) => {
                        t.current.files[0].size <
                        window.wplms_course_data.settings.upload_limit
                          ? (o(window.URL.createObjectURL(t.current.files[0])),
                            p(t.current.files[0]),
                            e.update(t.current.files[0], {
                              ..._,
                              key: "image",
                            }))
                          : (v(
                              window.wplms_course_data.translations
                                .image_size_error
                            ),
                            setTimeout(() => {
                              v(
                                window.wplms_course_data.translations
                                  .select_image
                              );
                            }, 3500));
                      },
                    })
                  : "video" == e.type
                  ? Ps("input", {
                      id: "fileupload_" + $s,
                      "data-type": e.type,
                      ref: t,
                      type: "file",
                      accept: "video/*",
                      onChange: (n) => {
                        t.current.files[0].size <
                        window.wplms_course_data.settings.upload_limit
                          ? (u(window.URL.createObjectURL(t.current.files[0])),
                            p(t.current.files[0]),
                            e.update(t.current.files[0], {
                              ..._,
                              key: "video",
                            }))
                          : (v(
                              window.wplms_course_data.translations
                                .image_size_error
                            ),
                            setTimeout(() => {
                              v(
                                window.wplms_course_data.translations
                                  .select_image
                              );
                            }, 3500));
                      },
                    })
                  : Ps("input", {
                      id: "fileupload_" + $s,
                      "data-type": e.type,
                      ref: t,
                      type: "file",
                      onChange: (n) => {
                        t.current.files &&
                          t.current.files[0] &&
                          (t.current.files[0].size < e.args.allowed_file_size
                            ? -1 !==
                              e.args.allowed_mime_types.indexOf(
                                t.current.files[0].type
                              )
                              ? (d(
                                  window.URL.createObjectURL(t.current.files[0])
                                ),
                                p(t.current.files),
                                e.update(t.current.files, {
                                  ..._,
                                  key: "attachment",
                                }))
                              : (v(
                                  window.wplms_course_data.translations
                                    .image_type_error
                                ),
                                setTimeout(() => {
                                  v(
                                    window.wplms_course_data.translations
                                      .select_image
                                  );
                                }, 3500))
                            : (v(
                                window.wplms_course_data.translations
                                  .image_size_error
                              ),
                              setTimeout(() => {
                                v(
                                  window.wplms_course_data.translations
                                    .select_image
                                );
                              }, 3500)));
                      },
                    })
              )
            )
          );
        },
        {
          Component: js,
          createElement: Hs,
          render: Bs,
          useState: Rs,
          useEffect: Us,
          Fragment: Js,
        } = wp.element,
        Xs = (e) => {
          const [t, n] = Rs(e.duration),
            [s, a] = Rs({ d: 0, h: 0, m: 0, s: 0 });
          Us(() => {
            e.start
              ? setTimeout(() => {
                  let s = t - 1;
                  s <= -1
                    ? e.update(e.quiz_id, "expired")
                    : s >= 0 && (n(s), i());
                }, 1e3)
              : (n(e.duration), i());
          }, [t, e.start, e.duration]);
          const i = () => {
            let e = { ...s },
              n = t;
            n > 86400
              ? ((e.d = Math.floor(n / 86400)), (n -= 86400 * e.d))
              : (e.d = 0),
              n > 3600
                ? ((e.h = Math.floor(n / 3600)), (n -= 3600 * e.h))
                : (e.h = 0),
              n > 60
                ? ((e.m = Math.floor(n / 60)), (n -= 60 * e.m))
                : (e.m = 0),
              (e.s = n),
              a(e);
          };
          let r = "c100 p0 big";
          if (t > -1) {
            let n = Math.floor(((e.duration - t) / e.duration) * 100);
            n <= 0 && (n = 1), (r = "c100 p" + n + " big");
          }
          return Hs(
            "div",
            { className: "quiztimer" },
            t >= 776736e3
              ? window.wplms_course_data.translations.unlimited_time
              : Hs(
                  Js,
                  null,
                  Hs(
                    "div",
                    { className: "circle_timer" },
                    Hs(
                      "div",
                      { className: r },
                      Hs(
                        "span",
                        null,
                        Hs(
                          "span",
                          { className: "timer_amount" },
                          s.d
                            ? Hs(
                                Js,
                                null,
                                Hs("span", null, s.d),
                                Hs("span", null, ":")
                              )
                            : "",
                          s.h
                            ? Hs(
                                Js,
                                null,
                                Hs("span", null, s.h),
                                Hs("span", null, ":")
                              )
                            : "",
                          s.m
                            ? Hs(
                                Js,
                                null,
                                Hs("span", null, s.m),
                                Hs("span", null, ":")
                              )
                            : "",
                          Hs("span", null, s.s)
                        ),
                        Hs(
                          "span",
                          { className: "timer_unit" },
                          s.d
                            ? Hs(
                                Js,
                                null,
                                Hs(
                                  "span",
                                  null,
                                  window.wplms_course_data.translations.days
                                ),
                                Hs("span", null)
                              )
                            : "",
                          s.h
                            ? Hs(
                                Js,
                                null,
                                Hs(
                                  "span",
                                  null,
                                  window.wplms_course_data.translations.hours
                                ),
                                Hs("span", null)
                              )
                            : "",
                          s.m
                            ? Hs(
                                Js,
                                null,
                                Hs(
                                  "span",
                                  null,
                                  window.wplms_course_data.translations.minutes
                                ),
                                Hs("span", null)
                              )
                            : "",
                          Hs(
                            "span",
                            null,
                            window.wplms_course_data.translations.seconds
                          )
                        )
                      ),
                      Hs(
                        "div",
                        { className: "slice" },
                        Hs("div", { className: "bar" }),
                        Hs("div", { className: "fill" })
                      )
                    )
                  )
                )
          );
        },
        { createContext: Ws } = wp.element,
        Ys = Ws({ course: {}, activeTab: "create_course", update: (e) => {} }),
        {
          createElement: Vs,
          render: Qs,
          useState: Ks,
          useEffect: Gs,
          useContext: Zs,
          Fragment: ea,
          RawHTML: ta,
        } = wp.element,
        na = (e) => {
          const [t, n] = Ks(e.field),
            [s, a] = (Zs(Ys), Ks({ post_content: "", raw: {} })),
            [i, r] = Ks(Math.round(1e5 * Math.random()));
          Gs(() => {
            if (e.field && e.field.id) {
              var t = new CustomEvent("load_vibe_editor", {
                detail: {
                  id: e.field.post_id ? e.field.post_id : "",
                  selector: ".vibe_" + e.field.id + i + "_editor",
                  content: e.field.hasOwnProperty("value") ? e.field.value : "",
                  raw: e.field.hasOwnProperty("raw") ? e.field.raw : "",
                  components: e.field.components ? e.field.components : "",
                  updater: e.field.id + i,
                },
              });
              document.dispatchEvent(t);
            }
          }, [e.field]),
            Gs(
              () => (
                e.field &&
                  e.field.id &&
                  document.addEventListener(
                    "vibe_editor_content_update_" + e.field.id + i,
                    o,
                    !1
                  ),
                () => {
                  e.field &&
                    e.field.id &&
                    document.removeEventListener(
                      "vibe_editor_content_update_" + e.field.id + i,
                      o
                    );
                }
              )
            );
          const o = (t) => {
            a({
              post_content: t.detail.raw_html,
              raw: t.detail.editor_content,
            });
            let s = { ...e.field };
            (s.value = t.detail.raw_html),
              (s.raw = t.detail.editor_content),
              JSON.stringify(s.raw) !== JSON.stringify(e.field.raw) &&
                (n(s), e.update(s, e.fieldIndex, "fieldvaluechanged"));
          };
          return Vs(
            "div",
            { className: "vibev_editor" },
            Vs(
              "div",
              { className: "vibe_" + t.id + i + "_editor" },
              Vs("textarea", { value: t.value })
            )
          );
        },
        sa = function (e) {
          if (void 0 === e) return !0;
          if ("undefined" === e) return !0;
          if (null == e) return !0;
          if ("number" == typeof e) return !1;
          if (Array.isArray(e) || "string" == typeof e || e instanceof String)
            return 0 === e.length;
          for (var t in e) if (e.hasOwnProperty(t)) return !1;
          return !0;
        },
        {
          createElement: aa,
          useState: ia,
          useEffect: ra,
          Fragment: oa,
          render: la,
          useContext: ua,
        } = wp.element,
        { dispatch: ca, select: da } = wp.data,
        ma = (e) => {
          const [t, n] = ia(!0),
            [s, a] = ia({}),
            [i, r] = ia([]),
            [o, l] = ia(""),
            [u, c] = ia(!1);
          let m = da("vibebp").getUser();
          (m.token = da("vibebp").getToken()),
            ra(() => {
              n(!0);
              console.log("First"+JSON.stringify(e, "I don't understand", 4));
              let t = `${window.wplms_course_data.api_url}/user/content/assignmentId/${e.assignment.id}`;
              e.hasOwnProperty("force") && e.force && (t += "?force"),
                fetch(t, {
                  method: "post",
                  headers: window.vibebp.xnonce
                    ? { "X-WP-Nonce": window.vibebp.xnonce }
                    : {},
                  body: JSON.stringify({ token: m.token }),
                })
                  .then((e) =>
                    e.ok
                      ? e.json()
                      : {
                          status: 0,
                          message:
                            window.wplms_course_data.translations
                              .error_loading_data,
                        }
                  )
                  .then((e) => {
                    if (e) {
                      if (e.hasOwnProperty("remaining"))
                        e.duration = e.remaining;
                      else if (
                        e.hasOwnProperty("start") &&
                        !0 !== e.start &&
                        e.start
                      ) {
                        let t = parseInt(e.duration) + parseInt(e.start),
                          n = Math.round(new Date().getTime() / 1e3);
                        e.duration = t > n ? t - n : 0;
                      }
                      e.hasOwnProperty("comment_content") &&
                        l(e.comment_content),
                        a(e),
                        n(!1),
                        document.dispatchEvent(
                          new Event("VibeBP_Editor_Content")
                        );
                    }
                  })
                  .catch((e) => {
                    n(!1),
                      console.error("Uh oh, an error!", e),
                      ca("vibebp").addNotification({
                        text: window.wplms_course_data.translations
                          .error_loading_data,
                      });
                  }),
                document.addEventListener(
                  "wplms_assignment_custom_upload",
                  ({ detail: e }) => {
                    if (
                      e.hasOwnProperty("data") &&
                      e.data.hasOwnProperty("Key") &&
                      e.data.Key.length
                    ) {
                      let t = [...i],
                        n = e.data.Key.split("/");
                      t.push({ ...e.data, name: n[n.length - 1] }), r(t);
                    }
                  }
                );
            }, [e.assignment]);
          const p = (t = null) => {
              let n = o;
              if (!t && s && s.type && "upload" == s.type) {
                if (!i || i.length <= 0)
                  return (
                    ca("vibebp").addNotification({
                      text: window.wplms_course_data.translations.upload_a_file,
                    }),
                    !1
                  );
                sa(n) &&
                  (n =
                    s.title +
                    " - " +
                    (m.displayname ? m.displayname : m.name ? m.name : ""));
              } else if (
                (t &&
                  sa(n) &&
                  (n =
                    s.title +
                    " - " +
                    (m.displayname ? m.displayname : m.name ? m.name : "")),
                !n || n.length <= 3)
              )
                return (
                  ca("vibebp").addNotification({
                    text: window.wplms_course_data.translations.error,
                  }),
                  !1
                );
              c(!0);
              var r = new FormData();
              r.append(
                "body",
                JSON.stringify({
                  comment: n,
                  attachments: i,
                  token: da("vibebp").getToken(),
                })
              ),
                i.length &&
                  i.map((e, t) => {
                    e instanceof File
                      ? r.append("files_" + t, e)
                      : r.append("files_" + t, JSON.stringify(e));
                  }),
                fetch(
                  `${window.wplms_course_data.api_url}/user/upload/assignmentId/${e.assignment.id}?upload`,
                  {
                    method: "post",
                    headers: window.vibebp.xnonce
                      ? { "X-WP-Nonce": window.vibebp.xnonce }
                      : {},
                    body: r,
                  }
                )
                  .then((e) =>
                    e.ok
                      ? e.json()
                      : {
                          status: 0,
                          message:
                            window.wplms_course_data.translations
                              .error_loading_data,
                        }
                  )
                  .then((t) => {
                    if ((c(!1), t)) {
                      let n = { ...s };
                      if (
                        (t.attachment_urls &&
                          t.attachment_urls.length &&
                          (n.attachment_urls = t.attachment_urls),
                        t.comment_id)
                      ) {
                        (n.flag = 1),
                          (n.already_submitted = !0),
                          e.hasOwnProperty("unitIndex")
                            ? e.update(
                                {
                                  unitIndex: e.unitIndex,
                                  assignmentIndex: e.assignmentIndex,
                                },
                                "complete"
                              )
                            : e.update({}, "submitassignment");
                        let t = `${window.wplms_course_data.api_url}/user/content/assignmentId/${e.assignment.id}`;
                        "undefined" != typeof localforage &&
                          window.vibebp.api.sw_enabled &&
                          localforage.getItem(t).then((e) => {
                            e &&
                              e.length &&
                              ((e = JSON.parse(e)),
                              (e = n),
                              localforage.setItem(t, JSON.stringify(e)));
                          });
                        let s = `${window.wplms_course_data.api_url}/student/assignments`;
                        _(s);
                      }
                      if (
                        (a(n),
                        t.hasOwnProperty("message") &&
                          ca("vibebp").addNotification({ text: t.message }),
                        t.status)
                      ) {
                        let t = e.course,
                          n = e.assignment.id;
                        document.dispatchEvent(
                          new CustomEvent("course_item_completed", {
                            detail: { course_id: t, item_id: n },
                          })
                        );
                      }
                    }
                  })
                  .catch((e) => {
                    c(!1),
                      console.error("Uh oh, an error!", e),
                      ca("vibebp").addNotification({
                        text: window.wplms_course_data.translations
                          .error_loading_data,
                      });
                  });
            },
            _ = (e, t) =>
              "undefined" != typeof localforage &&
              window.vibebp.api.sw_enabled &&
              navigator.onLine
                ? t
                  ? localforage.removeItem(e)
                  : localforage.iterate(function (t, n, s) {
                      e.length &&
                        n.length &&
                        n.includes(e) &&
                        localforage.removeItem(n);
                    })
                : new Promise((e) => {
                    e(1);
                  });
          let h = {
              allowed_mime_types: s.permit_mime,
              allowed_file_size: parseInt(s.permit_size),
            },
            w = s.duration;
            // to have access to the assignment id inside
            POST_ID_CURRENT = s.id;
            var code_scripts = document.querySelectorAll('[id^="code_assignment_script"]');
            console.log("code_scripts: ");
            console.log(code_scripts);
            if (s.content && code_scripts.length === 0){
                const parser = new DOMParser();
                // Parse the HTML string
                const htmlDocument = parser.parseFromString(s.content, 'text/html');
                // Access the parsed HTML document
                const htmlElement = htmlDocument.documentElement;
                // Assuming htmlElement is the root HTML element obtained from the parsed HTML
                const scriptElements = htmlElement.querySelectorAll('script'); 
                
                // add only if it does not exist
                // Loop through each script element
                scriptElements.forEach((scriptElement, index) => {
                    const scriptCode = scriptElement.textContent;
                    eval(scriptCode);
                    // postscribe(scriptElements, scriptElement.innerHTML);
                    console.log(scriptCode);
                    // Set the ID of the script element
                    scriptElement.id = `code_assignment_script_${index + 1}`;
                    
                    document.body.appendChild(scriptElement);
                });
            }
          return (
            s.hasOwnProperty("end_time") &&
              parseInt(s.end_time) &&
              parseInt(s.end_time) > new Date().getTime() &&
              (parseInt(s.end_time) - new Date().getTime()) / 1e3 < w &&
              (w = Math.floor(
                (parseInt(s.end_time) - new Date().getTime()) / 1e3
              )),
            t
              ? aa(d, null)
              : aa(
                  "div",
                  { className: "course_assignment_wrapper" },
                  aa(
                    "div",
                    { className: "course_assignment" },
                    aa(
                      "div",
                      { className: "assignment_details" },
                      s.hasOwnProperty("end_time") && parseInt(s.end_time)
                        ? aa(
                            "div",
                            { className: "end_timer" },
                            aa(
                              "span",
                              null,
                              window.wplms_course_data.translations.ends_in
                            ),
                            aa(Xs, {
                              duration: Math.floor(
                                (s.end_time - new Date().getTime()) / 1e3
                              ),
                              update: () => {},
                              quiz_id: s.id,
                              start: !0,
                            })
                          )
                        : "",
                      aa(
                        "div",
                        { className: "assignment_marks" },
                        aa("span", null, s.total_marks),
                        aa(
                          "span",
                          null,
                          window.wplms_course_data.translations.total_marks
                        )
                      ),
                      aa(Xs, {
                        duration: w,
                        update: (e, t) => {
                          "expired" == t && (s.already_submitted || p(!0));
                        },
                        quiz_id: s.id,
                        start: s.start,
                      })
                    ),
                    aa(
                      "div",
                      { className: "assignment_content_wrapper" },
                      aa("div", {
                        className: "assignment_content",
                        dangerouslySetInnerHTML: { __html: s.content },
                      }),
                      s.type &&
                        "upload" == s.type &&
                        s &&
                        s.permit_extension &&
                        s.permit_extension.length &&
                        s.flag <= 2
                        ? aa(
                            "div",
                            { className: "allowed_file_extenstions" },
                            aa(
                              "label",
                              null,
                              window.wplms_course_data.translations
                                .allowed_file_extenstions
                            ),
                            s.permit_extension.map((e) => aa("span", null, e))
                          )
                        : "",
                      s.hasOwnProperty("end_time") &&
                        parseInt(s.end_time) &&
                        parseInt(s.end_time) <= new Date().getTime()
                        ? ""
                        : s.hasOwnProperty("start_time") &&
                          parseInt(s.start_time) &&
                          parseInt(s.start_time) > new Date().getTime()
                        ? aa(
                            "div",
                            { className: "start_timer" },
                            aa(
                              "div",
                              null,
                              window.wplms_course_data.translations.starts_in
                            ),
                            aa(Xs, {
                              duration: Math.floor(
                                (parseInt(s.start_time) -
                                  new Date().getTime()) /
                                  1e3
                              ),
                              update: () => {
                                a({ ...s, start_time: s.start_time });
                              },
                              quiz_id: s.id,
                              start: !0,
                            })
                          )
                        : s.start
                        ? ""
                        : aa(
                            "a",
                            {
                              className:
                                "assignment_start_button button is-primary",
                              onClick: () => {
                                fetch(
                                  `${window.wplms_course_data.api_url}/user/start/assignmentId/${e.assignment.id}?post`,
                                  {
                                    method: "post",
                                    headers: window.vibebp.xnonce
                                      ? { "X-WP-Nonce": window.vibebp.xnonce }
                                      : {},
                                    body: JSON.stringify({
                                      token: da("vibebp").getToken(),
                                    }),
                                  }
                                )
                                  .then((e) =>
                                    e.ok
                                      ? e.json()
                                      : {
                                          status: 0,
                                          message:
                                            window.wplms_course_data
                                              .translations.error_loading_data,
                                        }
                                  )
                                  .then((t) => {
                                    if (t) {
                                      let n = { ...s };
                                      (n.start = Math.round(
                                        new Date().getTime() / 1e3
                                      )),
                                        a(n);
                                      let i = `${window.wplms_course_data.api_url}/user/content/assignmentId/${e.assignment.id}`,
                                        r = `${window.wplms_course_data.api_url}/student/assignments`;
                                      _(r, !0),
                                        "undefined" != typeof localforage &&
                                          window.vibebp.api.sw_enabled &&
                                          localforage.getItem(i).then((e) => {
                                            e &&
                                              e.length &&
                                              (e =
                                                JSON.parse(e)).hasOwnProperty(
                                                "duration"
                                              ) &&
                                              ((e.start = n.start),
                                              localforage.setItem(
                                                i,
                                                JSON.stringify(e)
                                              ));
                                          }),
                                        t.hasOwnProperty("message") &&
                                          ca("vibebp").addNotification({
                                            text: t.message,
                                          });
                                    }
                                  })
                                  .catch((e) => {
                                    console.error("Uh oh, an error!", e),
                                      ca("vibebp").addNotification({
                                        text: window.wplms_course_data
                                          .translations.error_loading_data,
                                      });
                                  });
                              },
                            },
                            window.wplms_course_data.translations
                              .start_assignment
                          ),
                      s.start && s.flag <= 2
                        ? aa(
                            oa,
                            null,
                            s.already_submitted
                              ? aa(
                                  oa,
                                  null,
                                  s.attachment_urls && s.attachment_urls.length
                                    ? aa(
                                        oa,
                                        null,
                                        window.wplms_course_data.translations
                                          .uploaded_files,
                                        aa(
                                          "div",
                                          {
                                            className: "assignment_attachments",
                                          },
                                          s.attachment_urls.map((e, t) =>
                                            e.hasOwnProperty("url")
                                              ? aa(
                                                  "div",
                                                  null,
                                                  aa("a", null, e.name)
                                                )
                                              : aa(
                                                  "div",
                                                  null,
                                                  aa(
                                                    "a",
                                                    {
                                                      href: e.url,
                                                      target: "_blank",
                                                      download: !0,
                                                    },
                                                    e.name
                                                  )
                                                )
                                          )
                                        )
                                      )
                                    : "",
                                  s.hasOwnProperty("end_time") &&
                                    parseInt(s.end_time) &&
                                    parseInt(s.end_time) <= new Date().getTime()
                                    ? ""
                                    : s.hasOwnProperty("flag") &&
                                      1 == s.flag &&
                                      s.duration > 0
                                    ? aa(
                                        "div",
                                        {
                                          className: "resubmit ",
                                          onClick: () => {
                                            (() => {
                                              let t = { ...s };
                                              (t.already_submitted = !1),
                                                (t.flag = 0),
                                                e.hasOwnProperty("unitIndex")
                                                  ? e.update(
                                                      {
                                                        unitIndex: e.unitIndex,
                                                        assignmentIndex:
                                                          e.assignmentIndex,
                                                      },
                                                      "retake"
                                                    )
                                                  : e.update(
                                                      {},
                                                      "retookassignment"
                                                    ),
                                                a(t);
                                            })();
                                          },
                                        },
                                        aa(
                                          "a",
                                          { className: "button is-primary" },
                                          window.wplms_course_data.translations
                                            .resubmit,
                                          aa("span", {
                                            className: "vicon vicon-close",
                                          })
                                        )
                                      )
                                    : ""
                                )
                              : "",
                            s.type && "upload" == s.type && !s.already_submitted
                              ? aa(
                                  "div",
                                  { className: "upload_assignment" },
                                  s.hasOwnProperty("custom_upload") &&
                                    s.custom_upload
                                    ? aa(
                                        "div",
                                        null,
                                        ((g = new CustomEvent(
                                          "custom_assignment_upload",
                                          { detail: { data: s } }
                                        )),
                                        document.dispatchEvent(g),
                                        aa("div", {
                                          className: "custom_assignment_upload",
                                          id: s.custom_upload,
                                        }))
                                      )
                                    : aa(Fs, {
                                        type: 1,
                                        update: (e, t) => {
                                          let n = [...i];
                                          n.push(new File([e[0]], e[0].name)),
                                            r(n);
                                        },
                                        args: h,
                                      }),
                                  i
                                    ? aa(
                                        "div",
                                        { className: "assignment_attachments" },
                                        i.map((e, t) =>
                                          aa(
                                            "div",
                                            null,
                                            aa("span", null, e.name),
                                            aa("span", {
                                              className: "vicon vicon-close",
                                              onClick: () => {
                                                ((e) => {
                                                  let t = [...i];
                                                  t.splice(e, 1), r(t);
                                                })(t);
                                              },
                                            })
                                          )
                                        )
                                      )
                                    : "",
                                  aa(
                                    na,
                                    o
                                      ? {
                                          field: {
                                            id: "assignment_text",
                                            value: o,
                                            components: ["editor"],
                                          },
                                          update: (e, t, n) => {
                                            l(e.value);
                                          },
                                        }
                                      : {
                                          field: {
                                            id: "assignment_text",
                                            components: ["editor"],
                                          },
                                          update: (e, t, n) => {
                                            l(e.value);
                                          },
                                        }
                                  )
                                )
                              : "",
                            !s.hasOwnProperty("type") ||
                              (s.type && "textarea" == s.type)
                              ? aa(na, {
                                  field: o
                                    ? {
                                        id: "assignment_text",
                                        value: o,
                                        components: ["editor"],
                                      }
                                    : {
                                        id: "assignment_text",
                                        components: ["editor"],
                                      },
                                  update: (e, t, n) => {
                                    l(e.value);
                                  },
                                })
                              : ""
                          )
                        : "",
                      s.flag && s.hasOwnProperty("marks") && s.flag > 1
                        ? aa(
                            "div",
                            { className: "assigment_evaluated" },
                            s.message ? aa("span", null, s.message) : "",
                            s.marks
                              ? aa(
                                  "span",
                                  null,
                                  window.wplms_course_data.translations
                                    .marks_obtained,
                                  " : ",
                                  s.marks
                                )
                              : "",
                            s.hasOwnProperty("instructor_remarks")
                              ? aa(
                                  "div",
                                  { className: "remarks" },
                                  aa(
                                    "h3",
                                    null,
                                    window.wplms_course_data.translations
                                      .instructor_remarks,
                                    " "
                                  ),
                                  aa("div", {
                                    dangerouslySetInnerHTML: {
                                      __html: s.instructor_remarks,
                                    },
                                  })
                                )
                              : ""
                          )
                        : ""
                    )
                  ),
                  s.start && !s.already_submitted
                    ? aa(
                        "a",
                        {
                          className: u
                            ? "button is-primary is-loading"
                            : "button is-primary",
                          onClick: () => {
                            p();
                          },
                        },
                        window.wplms_course_data.translations.submit_assignment
                      )
                    : ""
                )
          );
          var g;
        },
        { createContext: pa } = wp.element,
        _a = pa({ comments: {}, update: (e) => {} }),
        {
          createElement: ha,
          useState: wa,
          useEffect: ga,
          Fragment: fa,
          render: va,
          useContext: ya,
        } = wp.element,
        { dispatch: ba, select: ka } = wp.data,
        qa = (e) => {
          const [t, n] = wa({}),
            s = ya(_a);
          ga(() => {
            n(e.comment);
          }, [e.comment]);
          const a = (e) => {
              s.update({ comment: t }, e);
            },
            i = ka("vibebp").getUser();
          return t && Object.keys(t).length
            ? ha(
                "li",
                {
                  className:
                    "unit_comment_wrapper " +
                    (e.disable == t.comment_ID ? "disabled" : ""),
                },
                ha(
                  "div",
                  { className: "unit_comment" },
                  t.user
                    ? ha(
                        "div",
                        { className: "comment_user" },
                        t.user.avatar ? ha("img", { src: t.user.avatar }) : "",
                        t.user.name
                          ? ha("span", { className: "username" }, t.user.name)
                          : t.user.displayname
                          ? ha(
                              "span",
                              { className: "username" },
                              t.user.displayname
                            )
                          : ha(
                              "span",
                              { className: "username" },
                              window.wplms_course_data.translations.anonymous
                            )
                      )
                    : "",
                  ha(
                    "div",
                    { className: "unit_comment_content" },
                    ha(
                      "div",
                      { className: "unit_comment_header" },
                      ha(
                        "span",
                        null,
                        ha(G, { timestamp: parseInt(t.comment_date) })
                      ),
                      t.hasOwnProperty("comment_karma") &&
                        e.disable != t.comment_ID
                        ? ha(
                            "div",
                            { className: "comment_actions" },
                            i.id == t.user_id ||
                              (t.hasOwnProperty("user") && t.user.id == i.id) ||
                              Object.keys(i.caps).indexOf("manage_options") > -1
                              ? ha("span", {
                                  className: "vicon vicon-pencil",
                                  onClick: () => {
                                    a("edit");
                                  },
                                })
                              : "",
                            "note" == t.type ||
                              (t.hasOwnProperty("comment_type") &&
                                "note" == t.comment_type)
                              ? ""
                              : ha("span", {
                                  className: "vicon vicon-share",
                                  onClick: () => {
                                    a("reply");
                                  },
                                }),
                            i.id == t.user_id ||
                              (t.hasOwnProperty("user") && t.user.id == i.id)
                              ? ha(
                                  fa,
                                  null,
                                  parseInt(t.comment_parent) || "note" == t.type
                                    ? ""
                                    : t.question
                                    ? ha("span", {
                                        className: "vicon vicon-user active",
                                        title:
                                          window.wplms_course_data.translations
                                            .instructor_question,
                                      })
                                    : ha("span", {
                                        className: "vicon vicon-user",
                                        title:
                                          window.wplms_course_data.translations
                                            .ask_instructor,
                                        onClick: () => {
                                          fetch(
                                            `${window.wplms_course_data.api_url}/student/askQuestion/?post`,
                                            {
                                              method: "post",
                                              headers: window.vibebp.xnonce
                                                ? {
                                                    "X-WP-Nonce":
                                                      window.vibebp.xnonce,
                                                  }
                                                : {},
                                              body: JSON.stringify({
                                                comment: t,
                                                unit_id: s.unit_id,
                                                course_id: s.course_id,
                                                token: ka("vibebp").getToken(),
                                              }),
                                            }
                                          )
                                            .then((e) =>
                                              e.ok
                                                ? e.json()
                                                : {
                                                    status: 0,
                                                    message:
                                                      window.wplms_course_data
                                                        .translations
                                                        .error_loading_data,
                                                  }
                                            )
                                            .then((e) => {
                                              n({ ...t, question: !0 }),
                                                e
                                                  ? e.hasOwnProperty(
                                                      "message"
                                                    ) &&
                                                    ba(
                                                      "vibebp"
                                                    ).addNotification({
                                                      icon: "vicon vicon-user",
                                                      text: e.message,
                                                    })
                                                  : e.hasOwnProperty(
                                                      "message"
                                                    ) &&
                                                    ba(
                                                      "vibebp"
                                                    ).addNotification({
                                                      text: e.message,
                                                    });
                                            })
                                            .catch((e) => {
                                              console.error(
                                                "Uh oh, an error!",
                                                e
                                              ),
                                                ba("vibebp").addNotification({
                                                  text: window.wplms_course_data
                                                    .translations
                                                    .error_loading_data,
                                                });
                                            });
                                        },
                                      }),
                                  i.id == t.user_id ||
                                    (t.hasOwnProperty("user") &&
                                      t.user.id == i.id)
                                    ? ha("span", {
                                        className: "vicon vicon-trash",
                                        onClick: () => {
                                          a("delete");
                                        },
                                      })
                                    : ""
                                )
                              : ""
                          )
                        : ""
                    ),
                    ha("div", {
                      dangerouslySetInnerHTML: { __html: t.comment_content },
                    })
                  )
                ),
                t.child && t.child.length
                  ? ha(
                      "ul",
                      null,
                      t.child.map((t, n) =>
                        ha(qa, { comment: t, disable: e.disable })
                      )
                    )
                  : ""
              )
            : "";
        },
        xa = qa,
        {
          createElement: Na,
          useState: za,
          useEffect: Oa,
          Fragment: Sa,
          render: Ea,
        } = wp.element,
        { dispatch: Pa, select: Ia } = wp.data;
      let Ca = !1;
      const Ma = (e) => {
          const [t, n] = za([]),
            [s, a] = za(!1),
            [i, r] = za(0),
            [o, l] = za(!1),
            [u, c] = za(!1),
            [m, p] = za({}),
            [_, h] = za(!0),
            [w, g] = za("public"),
            f = Ia("vibebp").getUser(),
            v = Ia("vibebp").getToken(),
            y = { type: w, unit_id: e.unit_id, course_id: e.course_id };
          Oa(() => {
            p(y);
          }, [e.unit_id]),
            Oa(() => {
              let t = { type: w, unit_id: e.unit_id, course_id: e.course_id };
              p(t), h(!0), r(0), n([]), b(w, !0);
            }, [w]);
          const b = (s = null, o = null) => {
              s || (s = "public"), Ca && Ca.abort();
              let l = {},
                u = new AbortController();
              Ca && (l = { signal: u.signal }), (Ca = u);
              let c = i;
              o && (c = 0),
                c || a(!0),
                fetch(
                  `${window.wplms_course_data.api_url}/user/unitcomments/${e.unit_id}?page=${c}&per_page=20&force`,
                  {
                    method: "post",
                    ...l,
                    headers: window.vibebp.xnonce
                      ? { "X-WP-Nonce": window.vibebp.xnonce }
                      : {},
                    body: JSON.stringify({ token: v, type: s }),
                  }
                )
                  .then((e) =>
                    e.ok
                      ? e.json()
                      : {
                          status: 0,
                          message:
                            window.wplms_course_data.translations
                              .error_loading_data,
                        }
                  )
                  .then((e) => {
                    if (e) {
                      let s = [...t];
                      o && (s = []),
                        e.length
                          ? (e.map((t, n) => {
                              s.findIndex(
                                (e) => e.comment_ID === t.comment_ID
                              ) < 0 && s.push(N(t, e));
                            }),
                            n(s),
                            h(!1),
                            a(!1),
                            r(c + 1))
                          : (h(!0), a(!1));
                    }
                  })
                  .catch((e) => {
                    "AbortError" === e.name ||
                      (a(!1),
                      console.error("Uh oh, an error!", e),
                      Pa("vibebp").addNotification({
                        text: window.wplms_course_data.translations
                          .error_loading_data,
                      }));
                  });
            },
            k = (e, t, n) => {
              for (let s = 0; s < e.length; s++)
                e[s].comment_ID == t &&
                  (e[s].child && e[s].child.length
                    ? e[s].child.unshift(n)
                    : ((e[s].child = []), e[s].child.push(n))),
                  e[s].child && e[s].child.length && k(e[s].child, t, n);
              return e;
            },
            q = (e, t, n) => {
              for (let s = 0; s < e.length; s++)
                e[s].comment_ID == t && (e[s] = n),
                  e[s].child && e[s].child.length && q(e[s].child, t, n);
              return e;
            },
            x = (e, t, n) => {
              for (let s = 0; s < e.length; s++)
                e[s].comment_ID == t &&
                  (e[s].comment_content = n.comment_content),
                  e[s].child && e[s].child.length && q(e[s].child, t, n);
              return e;
            },
            N = (e, t) => (
              t.map((n, s) => {
                parseInt(e.comment_ID) === parseInt(n.comment_parent) &&
                  (e.hasOwnProperty("child") || (e.child = []),
                  t.splice(s, 1),
                  e.child.push(N(n, t)));
              }),
              e
            ),
            z = () => Math.floor(1e9 * Math.random() + 1),
            O = (e, t) => {
              if (e.comment_ID && t.length)
                for (var n = t.length - 1; n >= 0; n--) {
                  if (t[n].comment_ID == e.comment_ID) {
                    t.splice(n, 1);
                    break;
                  }
                  t[n].hasOwnProperty("child") &&
                    t[n].child.length &&
                    (t[n].child = O(e, t[n].child));
                }
              return t;
            },
            S = () => {
              switch (m.ctype) {
                case "new":
                default:
                  return "public" == w
                    ? window.wplms_course_data.translations.add_comment
                    : window.wplms_course_data.translations.add_note;
                case "new_question":
                  return window.wplms_course_data.translations.ask_question;
                case "reply":
                  return window.wplms_course_data.translations.reply;
                case "edit":
                  return "public" == w
                    ? window.wplms_course_data.translations.edit_comment
                    : window.wplms_course_data.translations.edit_note;
              }
            },
            E = (e, t) =>
              "undefined" != typeof localforage &&
              window.vibebp.api.sw_enabled &&
              navigator.onLine
                ? t
                  ? localforage.removeItem(e)
                  : localforage.iterate(function (t, n, s) {
                      e.length &&
                        n.length &&
                        n.includes(e) &&
                        localforage.removeItem(n);
                    })
                : new Promise((e) => {
                    e(1);
                  }),
            P = (t) => {
              let n = `${window.wplms_course_data.api_url}/user/unitcomments/${
                e.unit_id
              }?page=${i - 1}&per_page=20`;
              "undefined" != typeof localforage &&
                window.vibebp.api.sw_enabled &&
                localforage.getItem(n).then((e) => {
                  e &&
                    e.length &&
                    ((e = t), localforage.setItem(n, JSON.stringify(e)));
                });
            };
          let I = "";
          if (t.length && u) {
            let e = t.findIndex((e) => e.comment_ID === u);
            I = e > -1 ? t[e].ctype : "";
          }
          return Na(
            _a.Provider,
            {
              value: {
                comments: t,
                unit_id: e.unit_id,
                course_id: e.course_id,
                update: (s, a) => {
                  switch (a) {
                    case "edit":
                      l(!0),
                        (s.comment.ctype = a),
                        s.comment.user_id || (s.comment.user_id = f.id),
                        s.comment.user || (s.comment.user = f),
                        p(s.comment);
                      break;
                    case "reply":
                      l(!0),
                        p({
                          user_id: f.id,
                          user: f,
                          comment_ID: z(),
                          comment_parent: s.comment.comment_ID,
                          ctype: a,
                        });
                      break;
                    case "delete":
                      (i = s.comment).user.id &&
                        fetch(
                          `${window.wplms_course_data.api_url}/user/unitcomments/delete/${i.comment_ID}?post`,
                          {
                            method: "post",
                            headers: window.vibebp.xnonce
                              ? { "X-WP-Nonce": window.vibebp.xnonce }
                              : {},
                            body: JSON.stringify({
                              comment: i,
                              token: Ia("vibebp").getToken(),
                              course_id: e.course_id,
                            }),
                          }
                        )
                          .then((e) =>
                            e.ok
                              ? e.json()
                              : {
                                  status: 0,
                                  message:
                                    window.wplms_course_data.translations
                                      .error_loading_data,
                                }
                          )
                          .then((e) => {
                            if (e) {
                              let s = O(i, [...t]);
                              if ((n(s), e.status)) {
                                let e = `${window.wplms_course_data.api_url}/student/comments/0`;
                                E(e);
                              }
                              e.hasOwnProperty("message") &&
                                e.message.length &&
                                Pa("vibebp").addNotification({
                                  text: e.message,
                                }),
                                P(s);
                            }
                          })
                          .catch((e) => {
                            console.error("Uh oh, an error!", e),
                              Pa("vibebp").addNotification({
                                text: window.wplms_course_data.translations
                                  .error_loading_data,
                              });
                          });
                  }
                  var i;
                },
              },
            },
            Na(
              "div",
              { className: "unit_comments_enclosure" },
              Na(
                "div",
                {
                  className: o
                    ? "unit_comments_wrapper active"
                    : "unit_comments_wrapper",
                },
                Na(
                  "span",
                  null,
                  Na(
                    "span",
                    { onClick: e.back },
                    Na("span", { className: "vicon vicon-arrow-left" })
                  ),
                  Na("strong", null, window.wplms_course_data.translations[w]),
                  Na(
                    "span",
                    { onClick: e.expand },
                    Na("span", { className: "vicon vicon-align-right" })
                  )
                ),
                Na(
                  "div",
                  { className: "vibe_tabs" },
                  Na(
                    "span",
                    {
                      className: "vibe_tab " + ("public" == w ? "active" : ""),
                      onClick: () => {
                        g("public");
                      },
                    },
                    window.wplms_course_data.translations.comments
                  ),
                  Na(
                    "span",
                    {
                      className: "vibe_tab " + ("note" == w ? "active" : ""),
                      onClick: () => {
                        g("note");
                      },
                    },
                    window.wplms_course_data.translations.notes
                  ),
                  (() => {
                    if (
                      window.wplms_course_data?.custom_comment_options?.length
                    ) {
                      let e = [];
                      return (
                        window.wplms_course_data.custom_comment_options.map(
                          (t) => {
                            console.log(t),
                              e.push(
                                Na(
                                  "span",
                                  {
                                    className:
                                      "vibe_tab " +
                                      (w == t.value ? "active" : ""),
                                    onClick: () => {
                                      g(t.value);
                                    },
                                  },
                                  t.label
                                )
                              );
                          }
                        ),
                        e
                      );
                    }
                  })()
                ),
                s
                  ? Na(d, null)
                  : "public" == w || "note" == w
                  ? Na(
                      Sa,
                      null,
                      Na(
                        "div",
                        { className: "unit_comments" },
                        t && t.length
                          ? Na(
                              "ul",
                              null,
                              t.map((e, t) =>
                                Na(xa, { comment: e, disable: u })
                              )
                            )
                          : Na(
                              "div",
                              { className: "vbp_message" },
                              window.wplms_course_data.translations.no_comments
                            ),
                        Na(
                          "div",
                          { className: "loadmore_wrapper" },
                          _
                            ? ""
                            : Na(
                                "a",
                                {
                                  className: "link",
                                  onClick: () => {
                                    b(w);
                                  },
                                },
                                window.wplms_course_data.translations.load_more
                              )
                        )
                      ),
                      Na(
                        "div",
                        { className: "unit_comments_action" },
                        o
                          ? Na(
                              "div",
                              { className: "addcomment" },
                              Na(
                                "textarea",
                                {
                                  value: m.comment_content,
                                  onChange: (e) => {
                                    let t = { ...m };
                                    (t.comment_content = e.target.value), p(t);
                                  },
                                },
                                m.comment_content
                              ),
                              Na(
                                "div",
                                { className: "addcomment_buttons" },
                                Na(
                                  "a",
                                  {
                                    className: u
                                      ? "button is-primary is-loading"
                                      : "button is-primary",
                                    onClick: () => {
                                      if (!m.ctype)
                                        return (
                                          Pa("vibebp").addNotification({
                                            text: window.wplms_course_data
                                              .translations.insufficientdata,
                                          }),
                                          !1
                                        );
                                      if (
                                        !(
                                          m.comment_content &&
                                          m.comment_content.length > 3
                                        )
                                      )
                                        return (
                                          Pa("vibebp").addNotification({
                                            text: window.wplms_course_data
                                              .translations.add_more_content,
                                          }),
                                          !1
                                        );
                                      {
                                        m.comment_ID || (m.comment_ID = z()),
                                          c(m.comment_ID),
                                          m.comment_post_ID ||
                                            (m.comment_post_ID = e.unit_id);
                                        let s = m.comment_ID,
                                          a = [...t];
                                        switch (m.ctype) {
                                          case "new":
                                          case "new_question":
                                            a.unshift(m),
                                              n(a),
                                              P(a),
                                              fetch(
                                                `${window.wplms_course_data.api_url}/user/unitcomments/${e.unit_id}/new/0?post`,
                                                {
                                                  method: "post",
                                                  headers: window.vibebp.xnonce
                                                    ? {
                                                        "X-WP-Nonce":
                                                          window.vibebp.xnonce,
                                                      }
                                                    : {},
                                                  body: JSON.stringify({
                                                    ...m,
                                                    token:
                                                      Ia("vibebp").getToken(),
                                                    course_id: e.course_id,
                                                  }),
                                                }
                                              )
                                                .then((e) =>
                                                  e.ok
                                                    ? e.json()
                                                    : {
                                                        status: 0,
                                                        message:
                                                          window
                                                            .wplms_course_data
                                                            .translations
                                                            .error_loading_data,
                                                      }
                                                )
                                                .then((e) => {
                                                  if (e)
                                                    if (e.comment_data) {
                                                      let t = a.findIndex(
                                                        (e) =>
                                                          parseInt(
                                                            e.comment_ID
                                                          ) == m.comment_ID
                                                      );
                                                      t >= 0 &&
                                                        ((e.comment_data.user =
                                                          f),
                                                        a.splice(
                                                          t,
                                                          1,
                                                          e.comment_data
                                                        ),
                                                        n(a));
                                                      let s = `${window.wplms_course_data.api_url}/student/comments/0`;
                                                      E(s);
                                                    } else
                                                      Pa(
                                                        "vibebp"
                                                      ).addNotification({
                                                        text: e.message,
                                                      });
                                                  c(!1);
                                                })
                                                .catch((e) => {
                                                  console.error(
                                                    "Uh oh, an error!",
                                                    e
                                                  ),
                                                    Pa(
                                                      "vibebp"
                                                    ).addNotification({
                                                      text: window
                                                        .wplms_course_data
                                                        .translations
                                                        .error_loading_data,
                                                    });
                                                });
                                            break;
                                          case "edit":
                                            if (
                                              !m.comment_content ||
                                              m.comment_content.length < 4
                                            )
                                              return void Pa(
                                                "vibebp"
                                              ).addNotification({
                                                text: window.wplms_course_data
                                                  .translations
                                                  .add_more_content,
                                              });
                                            let t = x(a, s, m);
                                            n(t),
                                              P(a),
                                              m.comment_content,
                                              fetch(
                                                `${window.wplms_course_data.api_url}/user/unitcomments/${e.unit_id}/edit/${s}?post`,
                                                {
                                                  method: "post",
                                                  headers: window.vibebp.xnonce
                                                    ? {
                                                        "X-WP-Nonce":
                                                          window.vibebp.xnonce,
                                                      }
                                                    : {},
                                                  body: JSON.stringify({
                                                    ...m,
                                                    token:
                                                      Ia("vibebp").getToken(),
                                                    course_id: e.course_id,
                                                  }),
                                                }
                                              )
                                                .then((e) =>
                                                  e.ok
                                                    ? e.json()
                                                    : {
                                                        status: 0,
                                                        message:
                                                          window
                                                            .wplms_course_data
                                                            .translations
                                                            .error_loading_data,
                                                      }
                                                )
                                                .then((e) => {
                                                  if (e)
                                                    if (e.comment_data) {
                                                      e.comment_data.hasOwnProperty(
                                                        "user"
                                                      ) ||
                                                        (e.comment_data.user =
                                                          f),
                                                        (t = x(
                                                          a,
                                                          s,
                                                          e.comment_data
                                                        )),
                                                        n(t);
                                                      let i = `${window.wplms_course_data.api_url}/student/comments/0`;
                                                      E(i);
                                                    } else
                                                      Pa(
                                                        "vibebp"
                                                      ).addNotification({
                                                        text: window
                                                          .wplms_course_data
                                                          .translations.error,
                                                      });
                                                  c(!1);
                                                })
                                                .catch((e) => {
                                                  console.error(
                                                    "Uh oh, an error!",
                                                    e
                                                  ),
                                                    Pa(
                                                      "vibebp"
                                                    ).addNotification({
                                                      text: window
                                                        .wplms_course_data
                                                        .translations
                                                        .error_loading_data,
                                                    });
                                                });
                                            break;
                                          case "reply":
                                            if (
                                              !m.comment_content ||
                                              m.comment_content.length < 4
                                            )
                                              return void Pa(
                                                "vibebp"
                                              ).addNotification({
                                                text: window.wplms_course_data
                                                  .translations
                                                  .add_more_content,
                                              });
                                            let i = k(a, m.comment_parent, m);
                                            n(i),
                                              P(a),
                                              fetch(
                                                `${window.wplms_course_data.api_url}/user/unitcomments/${e.unit_id}/reply/${m.comment_parent}?post`,
                                                {
                                                  method: "post",
                                                  headers: window.vibebp.xnonce
                                                    ? {
                                                        "X-WP-Nonce":
                                                          window.vibebp.xnonce,
                                                      }
                                                    : {},
                                                  body: JSON.stringify({
                                                    ...m,
                                                    token:
                                                      Ia("vibebp").getToken(),
                                                    course_id: e.course_id,
                                                  }),
                                                }
                                              )
                                                .then((e) =>
                                                  e.ok
                                                    ? e.json()
                                                    : {
                                                        status: 0,
                                                        message:
                                                          window
                                                            .wplms_course_data
                                                            .translations
                                                            .error_loading_data,
                                                      }
                                                )
                                                .then((e) => {
                                                  if (e)
                                                    if (e.comment_data) {
                                                      e.comment_data.hasOwnProperty(
                                                        "user"
                                                      ) ||
                                                        (e.comment_data.user =
                                                          f),
                                                        (i = q(
                                                          a,
                                                          s,
                                                          e.comment_data
                                                        )),
                                                        n(i);
                                                      let t = `${window.wplms_course_data.api_url}/student/comments/0`;
                                                      E(t);
                                                    } else
                                                      Pa(
                                                        "vibebp"
                                                      ).addNotification({
                                                        text: window
                                                          .wplms_course_data
                                                          .translations.error,
                                                      });
                                                  c(!1);
                                                })
                                                .catch((e) => {
                                                  console.error(
                                                    "Uh oh, an error!",
                                                    e
                                                  ),
                                                    Pa(
                                                      "vibebp"
                                                    ).addNotification({
                                                      text: window
                                                        .wplms_course_data
                                                        .translations
                                                        .error_loading_data,
                                                    });
                                                });
                                        }
                                        p(y), l(!1);
                                      }
                                    },
                                  },
                                  S()
                                ),
                                Na(
                                  "a",
                                  {
                                    className: "link",
                                    onClick: () => {
                                      p(y), l(!1);
                                    },
                                  },
                                  window.wplms_course_data.translations.cancel
                                )
                              )
                            )
                          : Na(
                              Sa,
                              null,
                              Na(
                                "a",
                                {
                                  className:
                                    "new" == I && u
                                      ? "button is-primary is-loading"
                                      : "button is-primary",
                                  onClick: () => {
                                    let e = { ...m };
                                    (e.ctype = "new"),
                                      o && (e = {}),
                                      (e.user_id = f.id),
                                      (e.user = f),
                                      p(e),
                                      l(!o);
                                  },
                                },
                                Na("span", {
                                  className:
                                    "public" == w
                                      ? "vicon vicon-comments"
                                      : "vicon vicon-note",
                                }),
                                Na("span", null, S())
                              ),
                              "public" == w
                                ? Na(
                                    "a",
                                    {
                                      className:
                                        "new_question" == I && u
                                          ? "button is-primary is-loading"
                                          : "button is-primary",
                                      onClick: () => {
                                        let e = { ...m };
                                        (e.ctype = "new_question"),
                                          o && (e = {}),
                                          (e.user_id = f.id),
                                          (e.user = f),
                                          p(e),
                                          l(!o);
                                      },
                                    },
                                    Na("span", {
                                      className: "vicon vicon-help",
                                    }),
                                    Na(
                                      "span",
                                      null,
                                      window.wplms_course_data.translations
                                        .ask_question
                                    )
                                  )
                                : ""
                            )
                      )
                    )
                  : Na(
                      "div",
                      { className: "custom_comment_div unit_comments" },
                      (() => {
                        if (
                          window.wplms_course_data?.custom_comment_options
                            ?.length
                        ) {
                          var t = new CustomEvent(
                            "vibebp_custom_comment_options_" + w,
                            { detail: { div: w, unit: e.unit_id } }
                          );
                          return (
                            document.dispatchEvent(t),
                            Na("div", { className: w })
                          );
                        }
                      })()
                    )
              )
            )
          );
        },
        {
          createElement: La,
          useState: Ta,
          useEffect: Aa,
          Fragment: Da,
          render: $a,
          useContext: Fa,
        } = wp.element,
        { dispatch: ja, select: Ha } = wp.data,
        Ba = (e) => {
          const [t, n] = Ta(0),
            [s, a] = Ta(0),
            i = Fa(v),
            r = () => {
              const e = document.querySelector(".course_content_content");
              if (!e) return;
              let t = e.clientHeight - (e.offsetTop - 240) - window.innerHeight,
                n =
                  window.pageYOffset ||
                  document.documentElement.scrollTop ||
                  document.body.scrollTop ||
                  0;
              if (
                (document.querySelector("body").classList &&
                  document
                    .querySelector("body")
                    .classList.contains("course_status_fullscreen") &&
                  document.querySelector(".course_status") &&
                  ((n = document.querySelector(".course_status").scrollTop),
                  (t = e.clientHeight - e.offsetTop - window.innerHeight)),
                0 !== n)
              )
                return n > t
                  ? (i.update({ progress: 100 }, "updateprogress"),
                    void i.update({}, "progresscompleted"))
                  : void i.update(
                      { progress: (n / t) * 100 },
                      "updateprogress"
                    );
              i.update({ progress: 0 }, "updateprogress");
            },
            o = (e) => {
              a(Math.random());
            };
          return (
            Aa(
              () => (
                document.addEventListener("course_status_fullscreen_toggle", o),
                () => {
                  document.removeEventListener(
                    "course_status_fullscreen_toggle",
                    o
                  );
                }
              ),
              []
            ),
            Aa(
              () => (
                document.querySelector(".course_status") &&
                  (document.querySelector("body").classList &&
                  document
                    .querySelector("body")
                    .classList.contains("course_status_fullscreen")
                    ? document
                        .querySelector(".course_status")
                        .addEventListener("scroll", r)
                    : window.addEventListener("scroll", r)),
                () => {
                  document.querySelector(".course_status") &&
                    (document.querySelector("body").classList &&
                    document
                      .querySelector("body")
                      .classList.contains("course_status_fullscreen")
                      ? document
                          .querySelector(".course_status")
                          .removeEventListener("scroll", r)
                      : window.removeEventListener("scroll", r));
                }
              )
            ),
            ""
          );
        },
        {
          createElement: Ra,
          render: Ua,
          useState: Ja,
          useEffect: Xa,
          useContext: Wa,
          Fragment: Ya,
          RawHTML: Va,
        } = wp.element,
        Qa = (e) => {
          const [t, n] = Ja([]),
            [s, a] = Ja(() => {
              let t = e.maxstars ? e.maxstars - 1 : 4,
                n = [];
              for (; t >= 0; ) n.unshift(t), t--;
              return n;
            });
          return (
            Xa(() => {
              let t = e.rating ? e.rating - 1 : -1,
                s = [];
              for (; t >= 0; ) s.unshift(t), t--;
              n(s);
            }, [e.rating]),
            t && t.length >= 0
              ? Ra(
                  "div",
                  { className: "wplms-course-star-rating" },
                  s.map((s, a) => {
                    let i = 0;
                    return (
                      t.includes(a) && (i = 1),
                      Ra("span", {
                        className: "vicon vicon-star " + (i ? "golden" : ""),
                        onClick: (t) => {
                          ((t) => {
                            let s = [];
                            for (; t >= 0; ) s.unshift(t), t--;
                            n(s), e.update(s, "ratingchanged");
                          })(a);
                        },
                      })
                    );
                  })
                )
              : ""
          );
        },
        {
          createElement: Ka,
          render: Ga,
          useState: Za,
          useEffect: ei,
          Fragment: ti,
          useContext: ni,
          useRef: si,
        } = wp.element,
        { dispatch: ai, select: ii } = wp.data,
        ri = (e) => {
          const t = si(null),
            [n, s] = Za(Math.round(1e4 * Math.random())),
            [a, i] = Za(!1),
            [r, o] = Za(!1),
            l = (e, t) => {
              void 0 === t && (t = window.location.href);
              var n = t.match("[?&]" + e + "=([^&]+)");
              return n ? n[1] : null;
            };
          ei(
            () => (
              c().then(() => {
                if (document.querySelector("#item_" + e.index)) {
                  let t = {};
                  "youtube" == e.provider &&
                    (t.youtube = { modestbranding: 1 }),
                    "vimeo" == e.provider &&
                      (t.vimeo = { controls: !0, playsinline: !1 }),
                    window.wplms_course_data.course.status.seek_lock &&
                      (t.listeners = {
                        seek: (e) => {
                          var t = a.currentTime;
                          if (_getTargetTime(a, e) > t)
                            return e.preventDefault(), !1;
                        },
                      });
                  let n = null;
                  if (
                    e.hasOwnProperty("video") &&
                    e.video.hasOwnProperty("videotype") &&
                    "360" == e.video.videotype
                  )
                    (n = new Plyr(
                      document.querySelector("#item_" + e.index),
                      t
                    )),
                      (n.mediainfo = n.mediainfo || {}),
                      (n.mediainfo.projection = "360"),
                      n.vr({
                        projection: "AUTO",
                        debug: !0,
                        forceCardboard: !1,
                      });
                  else if (
                    (e.hasOwnProperty("src") &&
                      "mpd" == e.url.split(".").pop() &&
                      dashjs
                        .MediaPlayer()
                        .create()
                        .initialize(
                          document.querySelector("#item_" + e.index),
                          e.url,
                          !0
                        ),
                    (n = new Plyr(
                      document.querySelector("#item_" + e.index),
                      t
                    )),
                    e.hasOwnProperty("src") && "m3u8" == e.url.split(".").pop())
                  )
                    if (Hls.isSupported()) {
                      const t = new Hls();
                      t.loadSource(e.url),
                        t.attachMedia(
                          document.querySelector("#item_" + e.index)
                        );
                    } else
                      document.querySelector("#item_" + e.index).src = e.url;
                  n &&
                    (o(n),
                    n.once("loadeddata", () => {
                      let t = localStorage.getItem(e.url);
                      t && (n.currentTime = parseInt(t)),
                        i({ plyr: n, url: e.url });
                    }),
                    n.on("timeupdate", () => {
                      localStorage.setItem(e.url, Math.floor(n.currentTime));
                    }),
                    "youtube" == e.provider && n.pause(),
                    n.on("ready", () => {
                      if ("youtube" == e.provider) {
                        let t = l("t", e.url);
                        if (void 0 !== t && t)
                          (n.muted = !0), n.forward(parseInt(t)), n.play();
                        else {
                          let s = localStorage.getItem(e.url);
                          void 0 !== t &&
                            s &&
                            ((n.muted = !0), n.forward(parseInt(s)), n.play());
                        }
                      }
                    }),
                    n.on("playing", () => {
                      if ("youtube" == e.provider) {
                        let t = l("t", e.url);
                        ((void 0 !== t && t) || localStorage.getItem(e.url)) &&
                          (n.seekDone ||
                            (n.pause(), (n.muted = !1), (n.seekDone = !0)));
                      }
                    }),
                    n.once("ended", u));
                }
              }),
              () => {
                document.querySelector(".video_wrapper") &&
                  document.querySelector(".video_wrapper > div") &&
                  document.querySelector(".video_wrapper > div").remove();
              }
            ),
            [e.url]
          );
          const u = (t) => {
              e.update("ended", { index: e.index, src: e.url, event: t });
            },
            c = () => {
              if (
                (document.querySelector(".video_wrapper") &&
                  document.querySelector(".video_wrapper > div") &&
                  document.querySelector(".video_wrapper > div").remove(),
                "youtube" == e.provider)
              )
                return localforage.getItem(e.url).then((t) => {
                  if (t) {
                    var n = document.createElement("div"),
                      s = document.createElement("video");
                    s.setAttribute("id", "item_" + e.index);
                    var a = document.createElement("source");
                    a.setAttribute("src", URL.createObjectURL(t)),
                      a.setAttribute("type", t.type),
                      s.appendChild(a),
                      n.appendChild(s),
                      document.querySelector(".video_wrapper").appendChild(n);
                  } else
                    (n = document.createElement("div")).setAttribute(
                      "id",
                      "item_" + e.index
                    ),
                      n.setAttribute("data-plyr-provider", "youtube"),
                      n.setAttribute("data-plyr-embed-id", e.embed_id),
                      document.querySelector(".video_wrapper").appendChild(n);
                });
              if ("vimeo" == e.provider)
                return new Promise((t) => {
                  var n = document.createElement("div");
                  n.setAttribute("id", "item_" + e.index),
                    n.setAttribute("data-plyr-provider", "vimeo"),
                    n.setAttribute("data-plyr-embed-id", e.embed_id),
                    document.querySelector(".video_wrapper").appendChild(n),
                    t();
                });
              if ("audio" == e.provider) {
                var t = document.createElement("div");
                (s = document.createElement("audio")).setAttribute(
                  "id",
                  "item_" + e.index
                );
                var n = document.createElement("source");
                return localforage
                  .getItem(e.url)
                  .then((t) => {
                    t
                      ? (n.setAttribute("src", URL.createObjectURL(t)),
                        n.setAttribute("type", t.type))
                      : (n.setAttribute("src", e.url),
                        n.setAttribute("type", e.mime_type));
                  })
                  .then(() => {
                    s.appendChild(n),
                      t.appendChild(s),
                      document.querySelector(".video_wrapper").appendChild(t);
                  });
              }
              var s;
              return (
                (t = document.createElement("div")),
                (s = document.createElement("video")).setAttribute(
                  "id",
                  "item_" + e.index
                ),
                (n = document.createElement("source")),
                localforage
                  .getItem(e.url)
                  .then((t) => {
                    t
                      ? (n.setAttribute("src", URL.createObjectURL(t)),
                        n.setAttribute("type", t.type))
                      : (n.setAttribute("src", e.url),
                        n.setAttribute("type", e.mime_type));
                  })
                  .then(() => {
                    s.appendChild(n),
                      t.appendChild(s),
                      document.querySelector(".video_wrapper").appendChild(t);
                  })
              );
            };
          return Ka(
            "div",
            { className: "video_wrapper item_player_" + n },
            "youtube" == e.provider
              ? Ka("div", {
                  ref: t,
                  id: "item_" + e.index,
                  "data-plyr-provider": "youtube",
                  "data-plyr-embed-id": e.embed_id,
                })
              : "vimeo" == e.provider
              ? Ka("div", {
                  ref: t,
                  id: "item_" + e.index,
                  "data-plyr-provider": "vimeo",
                  "data-plyr-embed-id": e.embed_id,
                })
              : "local" == e.provider
              ? Ka(
                  "div",
                  null,
                  Ka(
                    "video",
                    {
                      className: "activity_meta video",
                      ref: t,
                      id: "item_" + e.index,
                    },
                    Ka("source", { src: e.url, type: e.mime_type })
                  )
                )
              : "audio" == e.provider
              ? Ka(
                  "div",
                  null,
                  Ka(
                    "audio",
                    {
                      className: "activity_meta video",
                      ref: t,
                      id: "item_" + e.index,
                    },
                    Ka("source", { src: e.url, type: e.mime_type })
                  )
                )
              : ""
          );
        },
        {
          createElement: oi,
          render: li,
          useState: ui,
          useEffect: ci,
          Fragment: di,
        } = wp.element,
        { dispatch: mi, select: pi } = wp.data,
        _i = (e) => {
          const [t, n] = ui({}),
            [s, a] = ui(!1),
            [i, r] = ui(null);
          ci(() => {
            n(e.question), a(!0);
          }, [e.question]);
          const o = (e, s = 0, a) => {
            let i = { ...t };
            "changed" == a &&
              ((i = e),
              n(i),
              (function (e) {
                if (null == e) return !0;
                if ("number" == typeof e) return !0;
                if (
                  Array.isArray(e) ||
                  "string" == typeof e ||
                  e instanceof String
                )
                  return 0 === e.length;
                for (var t in e) if (e.hasOwnProperty(t)) return !1;
                return !0;
              })(e.marked_answer)
                ? null == e.marked_answer && localStorage.removeItem(e.id)
                : "object" == typeof e.marked_answer ||
                  Array.isArray(e.marked_answer)
                ? localStorage.setItem(e.id, JSON.stringify(e.marked_answer))
                : localStorage.setItem(e.id, e.marked_answer));
          };
          return s
            ? t
              ? oi(
                  di,
                  null,
                  oi(
                    "div",
                    { className: "incourse" },
                    oi(
                      "div",
                      { className: "quiz_questions_content" },
                      oi(
                        "div",
                        { className: "question_cwrapper" },
                        oi(
                          "div",
                          { className: "question", "data-i": e.i },
                          oi($t, { question: t, update: o }),
                          ((e) => {
                            switch (e.type) {
                              case "smalltext":
                                return oi(ae, { question: e, update: o });
                              case "single":
                                return oi(ce, {
                                  question: e,
                                  update: o,
                                  quiz_id: e.id,
                                });
                              case "select":
                                return oi(we, {
                                  question: e,
                                  update: o,
                                  quiz_id: e.id,
                                });
                              case "multiple":
                                return oi(ke, {
                                  question: e,
                                  update: o,
                                  quiz_id: e.id,
                                });
                              case "fillblank":
                                return oi(Le, {
                                  question: e,
                                  update: o,
                                  quiz_id: e.id,
                                });
                              case "sort":
                                return oi(Xe, {
                                  question: e,
                                  update: o,
                                  quiz_id: e.id,
                                });
                              case "match":
                                return oi(it, {
                                  question: e,
                                  update: o,
                                  quiz_id: e.id,
                                });
                              case "truefalse":
                                return oi(dt, {
                                  question: e,
                                  update: o,
                                  quiz_id: e.id,
                                });
                              case "largetext":
                                return oi(gt, {
                                  question: e,
                                  update: o,
                                  quiz_id: e.id,
                                });
                            }
                          })({ ...t }),
                          t.attempted
                            ? ""
                            : oi(
                                "div",
                                {
                                  className: "quiz_check_answer button",
                                  onClick: (e) => {
                                    ((e) => {
                                      let t = { ...e };
                                      a(!1),
                                        (t = Nt(t, null, null, null, !0)),
                                        (t.attempted = !0),
                                        a(!0),
                                        n(t);
                                    })(t);
                                  },
                                },
                                window.wplms_course_data.translations
                                  .check_answer
                              ),
                          t.attempted ? oi(Ct, { question: t }) : "",
                          t.attempted && t.explanation.length
                            ? oi(
                                "div",
                                { className: "explanation" },
                                oi(
                                  "strong",
                                  null,
                                  window.wplms_course_data.translations
                                    .question_explanation
                                ),
                                oi("div", {
                                  dangerouslySetInnerHTML: {
                                    __html: t.explanation,
                                  },
                                })
                              )
                            : ""
                        )
                      ),
                      t.attempted && window.wplms_course_data.question_retries
                        ? oi(
                            "div",
                            {
                              className: "quiz_check_answer button",
                              onClick: (e) => {
                                (() => {
                                  let e = { ...t };
                                  if (e.hasOwnProperty("original")) {
                                    let t = e;
                                    (e = t.original),
                                      (e.original = t.original),
                                      n(e);
                                  }
                                })();
                              },
                            },
                            oi("span", { className: "vicon vicon-reload" }),
                            window.wplms_course_data.translations.retry
                          )
                        : ""
                    )
                  )
                )
              : ""
            : oi(d, null);
        },
        {
          createElement: hi,
          render: wi,
          useState: gi,
          useEffect: fi,
          Fragment: vi,
        } = wp.element,
        { dispatch: yi, select: bi } = wp.data;
      function ki(e) {
        if (null == e) return !0;
        if ("number" == typeof e) return !0;
        if (Array.isArray(e) || "string" == typeof e || e instanceof String)
          return 0 === e.length;
        for (var t in e) if (e.hasOwnProperty(t)) return !1;
        return !0;
      }
      const qi = (e) => {
          const [t, n] = gi([]),
            [s, a] = gi(!1),
            [i, r] = gi(0);
          fi(() => {
            o();
          }, [e.questions, i]);
          const o = () => {
            a(!1);
            let t = `${window.wplms_course_data.api_url}/course/questions/?client_id=${window.wplms_course_data.client_id}`;
            e.hasOwnProperty("force") && e.force && (t += "&force"),
              fetch(t, {
                method: "post",
                headers: window.vibebp.xnonce
                  ? { "X-WP-Nonce": window.vibebp.xnonce }
                  : {},
                body: JSON.stringify({
                  questions: e.questions,
                  page: i + 1,
                  per_page: window.wplms_course_data.practice_questions,
                }),
              })
                .then((e) =>
                  e.ok
                    ? e.json()
                    : {
                        status: 0,
                        message:
                          window.wplms_course_data.translations
                            .error_loading_data,
                      }
                )
                .then((e) => {
                  if (e.status) {
                    if (e.questions) {
                      let t = [];
                      e.questions.map((e) => {
                        let n = localStorage.getItem(e.id);
                        !ki(n) &&
                          ki(e.marked_answer) &&
                          ((function (e) {
                            try {
                              JSON.parse(e);
                            } catch (e) {
                              return !1;
                            }
                            return !0;
                          })(n)
                            ? (e.marked_answer = JSON.parse(n))
                            : (e.marked_answer = n)),
                          t.push(e);
                      }),
                        n(t);
                    }
                    a(!0);
                  } else console.log(e);
                })
                .catch((e) => {
                  a(!0),
                    console.error("Uh oh, an error!", e),
                    yi("vibebp").addNotification({
                      text: window.wplms_course_data.translations
                        .error_loading_data,
                    });
                });
          };
          return hi(
            "div",
            { className: "practice_questions" },
            s
              ? t
                  .filter(
                    (e, t) =>
                      t < (i + 1) * window.wplms_course_data.practice_questions
                  )
                  .map((e) =>
                    hi(_i, {
                      question: e,
                      i:
                        i * window.wplms_course_data.practice_questions +
                        t.indexOf(e) +
                        1,
                    })
                  )
              : hi(d, null),
            e.questions.length > window.wplms_course_data.practice_questions
              ? hi(
                  "div",
                  { className: "buttons has-addons" },
                  i > 0
                    ? hi("span", {
                        className: "button vicon vicon-angle-left",
                        onClick: () => {
                          s && r(i - 1);
                        },
                      })
                    : "",
                  i <
                    Math.floor(
                      e.questions.length /
                        window.wplms_course_data.practice_questions
                    )
                    ? hi("span", {
                        className: "button vicon vicon-angle-right",
                        onClick: () => {
                          s && r(i + 1);
                        },
                      })
                    : ""
                )
              : ""
          );
        },
        {
          createElement: xi,
          render: Ni,
          useState: zi,
          useEffect: Oi,
          Fragment: Si,
          useContext: Ei,
        } = wp.element,
        { dispatch: Pi, select: Ii } = wp.data,
        Ci = (e) => {
          const [t, n] = zi(null),
            [s, a] = zi(e.curriculumItem),
            [i, r] = zi(!1),
            [o, l] = zi(!1),
            [u, c] = zi(!1),
            [d, m] = zi(!1);
          Ei(v),
            Oi(
              () => () => {
                var t = new CustomEvent("unit_unloaded", {
                  detail: {
                    currentUnitKey: e.index,
                    coursestatus: e.coursestatus,
                    course: e.course,
                    user: Ii("vibebp").getUser(),
                  },
                });
                document.dispatchEvent(t);
              },
              [s.id]
            ),
            Oi(() => {
              if (
                (a({ ...e.curriculumItem }),
                e.curriculumItem.hasOwnProperty("meta") &&
                  e.curriculumItem.meta.hasOwnProperty("scorm_type") &&
                  e.curriculumItem.meta.scorm_type)
              ) {
                (window.scorm_page_type = "unit"),
                  window.hasOwnProperty("scorm_wplms_data") ||
                    (window.scorm_wplms_data = {});
                let e = Ii("vibebp").getUser();
                (window.scorm_wplms_data.module_id = s.id),
                  (window.scorm_wplms_data.type = "unit"),
                  (window.scorm_wplms_data.user_email = e.email),
                  (window.scorm_wplms_data.user_name = e.username),
                  (window.scorm_wplms_data.token = Ii("vibebp").getToken());
              }
            }, [e.curriculumItem]),
            Oi(() => {
              var e, t;
              if (
                document.querySelector(".wp-playlist.wp-video-playlist") &&
                void 0 !==
                  (e = JSON.parse(
                    document.querySelector(".wp-playlist-script").innerHTML
                  )) &&
                e &&
                e.hasOwnProperty("tracks") &&
                e.tracks.length
              ) {
                document.querySelector(".wp-playlist video") &&
                  document.querySelector(".wp-playlist video").remove(),
                  (t = document.createElement("div")).classList.add(
                    "wplms-playlist"
                  );
                var n = document.createElement("video");
                t.appendChild(n),
                  document
                    .querySelector(".wp-playlist.wp-video-playlist")
                    .parentNode.appendChild(t),
                  setTimeout(() => {
                    new Plyr(".wplms-playlist video").source = {
                      type: "video",
                      sources: e.tracks,
                    };
                    var t = document.createElement("div");
                    t.classList.add("wplms_playlist");
                    let n = document.createElement("div");
                    n.classList.add("prevnextbuttonsdiv");
                    let s = document.createElement("span");
                    s.classList.add("wp-playlist-prev-button");
                    let a = document.createElement("span");
                    a.classList.add("wp-playlist-next-button"),
                      n.appendChild(s),
                      n.appendChild(a),
                      document
                        .querySelector(".wp-playlist.wp-video-playlist")
                        .parentNode.prepend(n),
                      (a.onclick = (e) => {
                        p(e, "forward", "video");
                      }),
                      (s.onclick = (e) => {
                        p(e, "backward", "video");
                      }),
                      e.tracks.map((e, n) => {
                        var s = document.createElement("span");
                        s.classList.add("track"),
                          s.setAttribute("data-url", e.src),
                          (s.innerHTML = e.title),
                          n < 1 && s.classList.add("active"),
                          (s.onclick = (t) => {
                            t.preventDefault(),
                              document.querySelector(
                                ".wplms_playlist .track"
                              ) &&
                                document
                                  .querySelectorAll(".wplms_playlist .track")
                                  .forEach((e, t) => {
                                    e.classList.remove("active");
                                  }),
                              t.target.classList.add("active"),
                              document.querySelector(".wplms-playlist video") &&
                                document
                                  .querySelector(".wplms-playlist video")
                                  .remove();
                            var n = document.createElement("div");
                            n.classList.add("wplms-playlist");
                            var s = document.createElement("video");
                            n.appendChild(s),
                              document
                                .querySelector(".wp-playlist.wp-video-playlist")
                                .parentNode.appendChild(n),
                              setTimeout(() => {
                                new Plyr(".wplms-playlist video").source = {
                                  type: "video",
                                  sources: [e],
                                };
                              }, 200);
                          }),
                          t.appendChild(s);
                      }),
                      document
                        .querySelector(".wp-playlist.wp-video-playlist")
                        .appendChild(t);
                  }, 200);
              }
              document.querySelector(".wp-playlist.wp-audio-playlist") &&
                void 0 !==
                  (e = JSON.parse(
                    document.querySelector(".wp-playlist-script").innerHTML
                  )) &&
                e &&
                e.hasOwnProperty("tracks") &&
                e.tracks.length &&
                (document.querySelector(".wp-playlist audio") &&
                  document.querySelector(".wp-playlist audio").remove(),
                document.querySelector(".wp-playlist-current-item") &&
                  document.querySelector(".wp-playlist-current-item").remove(),
                (t = document.createElement("div")).classList.add(
                  "wplms-playlist"
                ),
                (n = document.createElement("audio")),
                t.appendChild(n),
                document
                  .querySelector(".wp-playlist.wp-audio-playlist")
                  .parentNode.appendChild(t),
                setTimeout(() => {
                  new Plyr(".wplms-playlist audio").source = {
                    type: "audio",
                    sources: e.tracks,
                  };
                  var t = document.createElement("div");
                  t.classList.add("wplms_playlist");
                  let n = document.createElement("div");
                  n.classList.add("prevnextbuttonsdiv");
                  let s = document.createElement("span");
                  s.classList.add("wp-playlist-prev-button");
                  let a = document.createElement("span");
                  a.classList.add("wp-playlist-next-button"),
                    n.appendChild(s),
                    n.appendChild(a),
                    document
                      .querySelector(".wp-playlist.wp-audio-playlist")
                      .parentNode.prepend(n),
                    (a.onclick = (e) => {
                      p(e, "forward", "audio");
                    }),
                    (s.onclick = (e) => {
                      p(e, "backward", "audio");
                    }),
                    e.tracks.map((e, n) => {
                      var s = document.createElement("span");
                      s.classList.add("track"),
                        s.setAttribute("data-url", e.src),
                        (s.innerHTML = e.title),
                        n < 1 && s.classList.add("active"),
                        (s.onclick = (t) => {
                          t.preventDefault(),
                            document.querySelector(".wplms_playlist .track") &&
                              document
                                .querySelectorAll(".wplms_playlist .track")
                                .forEach((e, t) => {
                                  e.classList.remove("active");
                                }),
                            t.target.classList.add("active"),
                            document.querySelector(".wplms-playlist") &&
                              document
                                .querySelector(".wplms-playlist")
                                .remove();
                          var n = document.createElement("div");
                          n.classList.add("wplms-playlist");
                          var s = document.createElement("audio");
                          n.appendChild(s),
                            document
                              .querySelector(".wp-playlist.wp-audio-playlist")
                              .parentNode.appendChild(n),
                            setTimeout(() => {
                              let t = new Plyr(".wplms-playlist audio");
                              (t.source = { type: "audio", sources: [e] }),
                                t.play();
                            }, 200);
                        }),
                        t.appendChild(s);
                    }),
                    document
                      .querySelector(".wp-playlist.wp-audio-playlist")
                      .appendChild(t);
                }, 200));
            }, [s]);
          const p = (e, t, n) => {
            if ("forward" == t) {
              for (
                let e = 0;
                e <
                document.querySelectorAll(
                  ".wp-" + n + "-playlist .wplms_playlist .track"
                ).length;
                e++
              )
                if (
                  document
                    .querySelectorAll(
                      ".wp-" + n + "-playlist .wplms_playlist .track"
                    )
                    [e].classList.contains("active") &&
                  e <
                    document.querySelectorAll(
                      ".wp-" + n + "-playlist .wplms_playlist .track"
                    ).length -
                      1
                ) {
                  document.querySelector(".wplms_playlist .track") &&
                    document
                      .querySelectorAll(".wplms_playlist .track")
                      .forEach((e, t) => {
                        e.classList.remove("active");
                      }),
                    document
                      .querySelectorAll(
                        ".wp-" + n + "-playlist .wplms_playlist .track"
                      )
                      [e + 1].classList.add("active"),
                    document.querySelector(".wplms-playlist") &&
                      document.querySelector(".wplms-playlist").remove();
                  let t = document.createElement("div");
                  t.classList.add("wplms-playlist");
                  let s = document.createElement(n);
                  t.appendChild(s),
                    document
                      .querySelector(".wp-playlist.wp-" + n + "-playlist")
                      .parentNode.appendChild(t),
                    setTimeout(() => {
                      let t = new Plyr(".wplms-playlist " + n);
                      (t.source = {
                        type: n,
                        sources: [
                          {
                            src: document
                              .querySelectorAll(
                                ".wp-" + n + "-playlist .wplms_playlist .track"
                              )
                              [e + 1].getAttribute("data-url"),
                          },
                        ],
                      }),
                        t.play();
                    }, 200);
                  break;
                }
            } else
              for (
                let e =
                  document.querySelectorAll(
                    ".wp-" + n + "-playlist .wplms_playlist .track"
                  ).length - 1;
                e >= 0;
                e--
              )
                if (
                  document
                    .querySelectorAll(
                      ".wp-" + n + "-playlist .wplms_playlist .track"
                    )
                    [e].classList.contains("active") &&
                  0 != e
                ) {
                  document.querySelector(".wplms_playlist .track") &&
                    document
                      .querySelectorAll(".wplms_playlist .track")
                      .forEach((e, t) => {
                        e.classList.remove("active");
                      }),
                    document
                      .querySelectorAll(
                        ".wp-" + n + "-playlist .wplms_playlist .track"
                      )
                      [e - 1].classList.add("active"),
                    document.querySelector(".wplms-playlist") &&
                      document.querySelector(".wplms-playlist").remove();
                  var s = document.createElement("div");
                  s.classList.add("wplms-playlist");
                  var a = document.createElement(n);
                  s.appendChild(a),
                    document
                      .querySelector(".wp-playlist.wp-" + n + "-playlist")
                      .parentNode.appendChild(s),
                    setTimeout(() => {
                      let t = new Plyr(".wplms-playlist " + n);
                      (t.source = {
                        type: n,
                        sources: [
                          {
                            src: document
                              .querySelectorAll(
                                ".wp-" + n + "-playlist .wplms_playlist .track"
                              )
                              [e - 1].getAttribute("data-url"),
                          },
                        ],
                      }),
                        t.play();
                    }, 200);
                  break;
                }
          };
          let _ = "";
          if (
            s.meta.hasOwnProperty("video") &&
            "object" == typeof s.meta.video &&
            "video" == s.meta.video.type
          ) {
            let e = s.meta.video.url.split(".");
            _ =
              "mov" === e[e.length - 1]
                ? "video/mp4"
                : "video/" + e[e.length - 1];
          }
          if (
            s.meta.hasOwnProperty("audio") &&
            "object" == typeof s.meta.audio &&
            "audio" == s.meta.audio.type
          ) {
            let e = s.meta.audio.url.split(".");
            switch (e[e.length - 1]) {
              case "m4a":
                _ = "audio/mp4";
                break;
              case "oga":
                _ = "audio/ogg";
                break;
              default:
                _ = "audio/" + e[e.length - 1];
            }
          }
          const h = async (t, n, a = null) => {
            if (t) {
              let o = {};
              window.wplms_course_data.course.status.seek_lock &&
                (o.listeners = {
                  seek: (e) => {
                    var t = i.currentTime,
                      n = ((e, t) =>
                        "object" != typeof t ||
                        ("input" !== t.type && "change" !== t.type)
                          ? Number(t)
                          : (t.target.value / t.target.max) * e.media.duration)(
                        i,
                        e
                      );
                    if (n > t) return e.preventDefault(), !1;
                  },
                });
              const l = await localforage.getItem(n);
              l &&
                document.querySelector(".media_video_meta" + a + " source") &&
                document
                  .querySelector(".media_video_meta" + a + " source")
                  .setAttribute("src", URL.createObjectURL(l));
              let u = new Plyr(t, o);
              u.once("loadeddata", () => {
                let e = localStorage.getItem(n);
                e && e <= u.duration && (u.currentTime = e),
                  r({ plyr: u, url: n });
              }),
                null === a ||
                  s.status ||
                  u.once("ended", (t) => {
                    e.update({ index: a, src: n, event: t }, "videosended");
                  });
            }
          };
          ((e, t, n = []) => {
            const s = ds(Date.now());
            ls(() => {
              const n = setTimeout(function () {
                Date.now() - s.current >= t && (e(), (s.current = Date.now()));
              }, t - (Date.now() - s.current));
              return () => {
                clearTimeout(n);
              };
            }, [t, ...n]);
          })(
            () => {
              void 0 !== i.player &&
                i.player.on("playing", () => {
                  localStorage.setItem(i.url, i.player.currentTime);
                });
            },
            500,
            [i, o]
          );
          const w = (e, t) => {
              let n = { ...s };
              n.meta.hasOwnProperty("assignments") &&
                n.meta.assignments.length &&
                n.meta.assignments[t] &&
                (n.meta.assignments[t].show = e),
                a(n);
            },
            g = (t, n) => {
              "complete" == n &&
                e.update(
                  { assignmentIndex: t.assignmentIndex },
                  "completeUnitAssigmnent"
                ),
                "retake" == n &&
                  e.update(
                    { assignmentIndex: t.assignmentIndex },
                    "retakeUnitAssigmnent"
                  );
            },
            f = (e) => {
              e && !t && n(e);
            },
            y = (t, n) => {
              e.update(n, "mediaended");
            };
          let b = [],
            k = [];
          if (
            s.meta.hasOwnProperty("video") &&
            "object" == typeof s.meta.video
          ) {
            if ("youtube" == s.meta.video.type) {
              let e = s.meta.video.url.match(
                /(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&|?]+)/
              );
              e && e.length && (b = e[1]);
            }
            "vimeo" == s.meta.video.type &&
              (k = s.meta.video.url.match(
                /(http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)/
              ));
          }
          return xi(
            "div",
            { className: "course_content_content" },
            e.hasOwnProperty("noLabels") && e.noLabels
              ? ""
              : xi(
                  Si,
                  null,
                  xi(
                    "span",
                    { className: "lesson_info" },
                    xi(
                      "span",
                      null,
                      window.wplms_course_data.reports.module.unit + " ",
                      e.item_number + "/" + e.total_item_count
                    ),
                    xi("span", null, " "),
                    xi(G, { timestamp: s.duration, notimediff: 1 })
                  ),
                  xi("h2", { dangerouslySetInnerHTML: { __html: s.title } })
                ),
            xi(
              "div",
              null,
              (s.meta.hasOwnProperty("access") && s.meta.access) ||
                !s.meta.hasOwnProperty("drip_time")
                ? s.meta.access
                  ? s.meta.hasOwnProperty("video") &&
                    "object" == typeof s.meta.video &&
                    !Array.isArray(s.meta.video)
                    ? "youtube" == s.meta.video.type
                      ? xi(
                          "div",
                          null,
                          b && b.length
                            ? xi(ri, {
                                provider: "youtube",
                                index: e.index,
                                embed_id: b,
                                url: s.meta.video.url,
                                update: y,
                              })
                            : ""
                        )
                      : "vimeo" == s.meta.video.type &&
                        void 0 !== k &&
                        k &&
                        void 0 !== k[4] &&
                        k[4]
                      ? xi(
                          "div",
                          null,
                          xi(ri, {
                            provider: "vimeo",
                            index: e.index,
                            embed_id: k[4],
                            url: s.meta.video.url,
                            update: y,
                          })
                        )
                      : xi(
                          "div",
                          null,
                          xi(ri, {
                            provider: "local",
                            index: e.index,
                            src: s.meta.video.url,
                            mime_type: _,
                            url: s.meta.video.url,
                            video: s.meta.video,
                            update: y,
                          })
                        )
                    : s.meta.hasOwnProperty("audio") &&
                      "object" == typeof s.meta.audio &&
                      !Array.isArray(s.meta.audio) &&
                      s.meta.audio.url.length
                    ? xi(
                        "div",
                        null,
                        xi(ri, {
                          provider: "audio",
                          index: e.index,
                          src: s.meta.audio.url,
                          mime_type: _,
                          url: s.meta.audio.url,
                          video: s.meta.audio,
                          update: y,
                        })
                      )
                    : s.meta.hasOwnProperty("package")
                    ? xi(
                        "div",
                        { className: "unit_iframe_wrapper" },
                        xi("iframe", {
                          src: s.meta.package.src,
                          width: "100%",
                          height: "100%",
                          frameborder: "0",
                          allowfullscreen: "allowfullscreen",
                        })
                      )
                    : xi("div", { className: s.type + "" + s.id })
                  : ""
                : xi(Dn, {
                    start: !0,
                    duration: s.meta.drip_time,
                    update: (t, n) => {
                      "expired" == n &&
                        e.update({ index: e.index }, "loadunit");
                    },
                    quiz_id: e.index,
                  })
            ),
            s.meta &&
              s.meta.hasOwnProperty("access") &&
              s.meta.access &&
              s.meta.hasOwnProperty("video") &&
              s.meta.video.length
              ? xi(
                  "div",
                  { className: "unit_videos" },
                  s.meta.video.map((e, t) =>
                    xi(
                      "div",
                      { className: "video_wrapper" },
                      xi(
                        "video",
                        {
                          className: "activity_meta video media_video_meta" + t,
                          ref: (n) => h(n, e, t),
                        },
                        xi("source", { src: e, type: "video/mp4" })
                      )
                    )
                  )
                )
              : "",
            s.meta &&
              s.meta.hasOwnProperty("access") &&
              s.meta.access &&
              s.meta.hasOwnProperty("audio") &&
              s.meta.audio.length
              ? xi(
                  "div",
                  { className: "unit_videos" },
                  s.meta.audio.map((e, t) =>
                    xi(
                      "div",
                      { className: "video_wrapper" },
                      xi(
                        "audio",
                        {
                          className: "activity_meta video media_video_meta" + t,
                          ref: (n) => h(n, e, t),
                        },
                        xi("source", { src: e, type: "audio/mpeg" })
                      )
                    )
                  )
                )
              : "",
            s.meta &&
              s.meta.hasOwnProperty("access") &&
              s.meta.access &&
              s.meta.hasOwnProperty("iframes") &&
              s.meta.iframes.length
              ? xi(
                  "div",
                  { className: "unit_iframes" },
                  s.meta.iframes.map((e, t) =>
                    "object" == typeof e && e.hasOwnProperty("value")
                      ? xi(
                          "div",
                          { className: "unit_iframe_wrapper " + e.shortcode },
                          xi("iframe", {
                            src: e.value,
                            width: "560",
                            height: "315",
                            frameborder: "0",
                            allowfullscreen: "allowfullscreen",
                          })
                        )
                      : xi(
                          "div",
                          { className: "unit_iframe_wrapper" },
                          xi("iframe", {
                            src: e,
                            width: "560",
                            height: "315",
                            frameborder: "0",
                            allowfullscreen: "allowfullscreen",
                          })
                        )
                  )
                )
              : "",
            s.hasOwnProperty("unit_type") && "elementor" === s.unit_type
              ? (() => {
                  if (
                    s.meta.hasOwnProperty("access") &&
                    s.meta.access &&
                    s.hasOwnProperty("meta") &&
                    s.meta.hasOwnProperty("link") &&
                    s.meta.link.length
                  ) {
                    let e = s.meta.link;
                    return (
                      e.includes("?")
                        ? (e += "&token=" + Ii("vibebp").getToken())
                        : (e += "?token=" + Ii("vibebp").getToken()),
                      xi(
                        "div",
                        { className: "wplms_iframe_wrapper" },
                        xi("iframe", { src: e, width: "100%" })
                      )
                    );
                  }
                  return xi("div", {
                    dangerouslySetInnerHTML: { __html: s.content },
                    ref: f,
                  });
                })()
              : xi("div", {
                  dangerouslySetInnerHTML: { __html: s.content },
                  ref: f,
                }),
            s.meta &&
              s.meta.hasOwnProperty("access") &&
              s.meta.access &&
              s.meta.attachments &&
              s.meta.attachments.length
              ? xi(
                  "div",
                  { className: "unit_attachments" },
                  xi(
                    "h3",
                    null,
                    window.wplms_course_data.translations.attachments
                  ),
                  s.meta.attachments.map((e, t) => {
                    return xi(
                      "div",
                      { className: "attachment" },
                      xi(
                        "span",
                        null,
                        "application/pdf" == (n = e.type)
                          ? xi("span", {
                              className: "attachment_icon",
                              dangerouslySetInnerHTML: {
                                __html:
                                  window.wplms_course_data.course
                                    .attachment_types["application/pdf"],
                              },
                            })
                          : "image/jpeg" == n
                          ? xi("span", {
                              className: "attachment_icon",
                              dangerouslySetInnerHTML: {
                                __html:
                                  window.wplms_course_data.course
                                    .attachment_types["image/jpeg"],
                              },
                            })
                          : "video/mp4" == n
                          ? xi("span", {
                              className: "attachment_icon",
                              dangerouslySetInnerHTML: {
                                __html:
                                  window.wplms_course_data.course
                                    .attachment_types["video/mp4"],
                              },
                            })
                          : "application/pdf" == n || "application/pdf" == n
                          ? ""
                          : xi("span", {
                              className: "attachment_icon",
                              dangerouslySetInnerHTML: {
                                __html:
                                  window.wplms_course_data.course
                                    .attachment_types.default,
                              },
                            }),
                        xi("strong", {
                          dangerouslySetInnerHTML: { __html: e.name },
                        })
                      ),
                      xi("a", {
                        href: e.link,
                        target: "_blank",
                        className: "vicon vicon-download",
                      })
                    );
                    var n;
                  })
                )
              : "",
            s.meta &&
              s.meta.hasOwnProperty("access") &&
              s.meta.access &&
              s.meta.attachments &&
              s.meta.assignments.length
              ? xi(
                  "div",
                  { className: "unit_assignments" },
                  xi(
                    "h3",
                    null,
                    window.wplms_course_data.translations.assignments
                  ),
                  s.meta.assignments.map((t, n) =>
                    xi(
                      "div",
                      { className: "assignment" },
                      xi(
                        "div",
                        { className: "assignment_heading" },
                        xi("span", null, t.title),
                        xi(
                          "div",
                          { className: "assignment_meta" },
                          t && t.hasOwnProperty("show") && t.show
                            ? xi("a", {
                                className: "vicon vicon-minus",
                                onClick: () => {
                                  w(!1, n);
                                },
                              })
                            : xi("a", {
                                className: "vicon vicon-plus",
                                onClick: () => {
                                  w(!0, n);
                                },
                              })
                        )
                      ),
                      t.show
                        ? xi(
                            "div",
                            { className: "assignment_content_wrapper" },
                            xi(ma, {
                              assignment: t,
                              assignmentIndex: n,
                              index: n,
                              unitIndex: e.index,
                              update: g,
                            })
                          )
                        : ""
                    )
                  )
                )
              : "",
            s.meta.hasOwnProperty("access") &&
              s.meta.access &&
              s.meta.hasOwnProperty("pratice_questions") &&
              s.meta.pratice_questions.length
              ? xi(
                  "div",
                  { className: "pratice_questions" },
                  xi(qi, { questions: s.meta.pratice_questions })
                )
              : ""
          );
        };
      var Mi = (function () {
          function e() {}
          return (
            (e.prototype.expandToken = function (e) {
              for (var t = [], n = "", s = 0, a = e.length; s < a; ++s)
                (n += e.charAt(s)), t.push(n);
              return t;
            }),
            e
          );
        })(),
        Li = (function () {
          function e() {}
          return (
            (e.prototype.sanitize = function (e) {
              return e ? e.toLocaleLowerCase().trim() : "";
            }),
            e
          );
        })();
      function Ti(e, t) {
        t = t || [];
        for (var n = (e = e || {}), s = 0; s < t.length; s++)
          if (null == (n = n[t[s]])) return null;
        return n;
      }
      var Ai = (function () {
          function e(e) {
            (this._uidFieldName = e),
              (this._tokenToIdfCache = {}),
              (this._tokenMap = {});
          }
          var t = e.prototype;
          return (
            (t.indexDocument = function (e, t, n) {
              this._tokenToIdfCache = {};
              var s,
                a = this._tokenMap;
              "object" != typeof a[e]
                ? (a[e] = s =
                    {
                      $numDocumentOccurrences: 0,
                      $totalNumOccurrences: 1,
                      $uidMap: {},
                    })
                : (s = a[e]).$totalNumOccurrences++;
              var i = s.$uidMap;
              "object" != typeof i[t]
                ? (s.$numDocumentOccurrences++,
                  (i[t] = { $document: n, $numTokenOccurrences: 1 }))
                : i[t].$numTokenOccurrences++;
            }),
            (t.search = function (e, t) {
              for (var n = {}, s = 0, a = e.length; s < a; s++) {
                var i,
                  r = e[s],
                  o = this._tokenMap[r];
                if (!o) return [];
                if (0 === s)
                  for (
                    var l = 0, u = (i = Object.keys(o.$uidMap)).length;
                    l < u;
                    l++
                  )
                    n[(c = i[l])] = o.$uidMap[c].$document;
                else
                  for (l = 0, u = (i = Object.keys(n)).length; l < u; l++) {
                    var c = i[l];
                    "object" != typeof o.$uidMap[c] && delete n[c];
                  }
              }
              var d = [];
              for (var c in n) d.push(n[c]);
              var m = this._createCalculateTfIdf();
              return d.sort(function (n, s) {
                return m(e, s, t) - m(e, n, t);
              });
            }),
            (t._createCalculateIdf = function () {
              var e = this._tokenMap,
                t = this._tokenToIdfCache;
              return function (n, s) {
                if (!t[n]) {
                  var a = void 0 !== e[n] ? e[n].$numDocumentOccurrences : 0;
                  t[n] = 1 + Math.log(s.length / (1 + a));
                }
                return t[n];
              };
            }),
            (t._createCalculateTfIdf = function () {
              var e = this._tokenMap,
                t = this._uidFieldName,
                n = this._createCalculateIdf();
              return function (s, a, i) {
                for (var r = 0, o = 0, l = s.length; o < l; ++o) {
                  var u,
                    c = s[o],
                    d = n(c, i);
                  d === 1 / 0 && (d = 0),
                    (u = t instanceof Array ? a && Ti(a, t) : a && a[t]),
                    (r +=
                      (void 0 !== e[c] && void 0 !== e[c].$uidMap[u]
                        ? e[c].$uidMap[u].$numTokenOccurrences
                        : 0) * d);
                }
                return r;
              };
            }),
            e
          );
        })(),
        Di = /[^a-zа-яё0-9\-']+/i,
        $i = (function () {
          function e() {}
          return (
            (e.prototype.tokenize = function (e) {
              return e.split(Di).filter(function (e) {
                return e;
              });
            }),
            e
          );
        })();
      function Fi(e, t) {
        for (var n = 0; n < t.length; n++) {
          var s = t[n];
          (s.enumerable = s.enumerable || !1),
            (s.configurable = !0),
            "value" in s && (s.writable = !0),
            Object.defineProperty(e, s.key, s);
        }
      }
      var ji = (function () {
        function e(e) {
          if (!e)
            throw Error(
              "js-search requires a uid field name constructor parameter"
            );
          (this._uidFieldName = e),
            (this._indexStrategy = new Mi()),
            (this._searchIndex = new Ai(e)),
            (this._sanitizer = new Li()),
            (this._tokenizer = new $i()),
            (this._documents = []),
            (this._searchableFields = []);
        }
        var t,
          n,
          s = e.prototype;
        return (
          (s.addDocument = function (e) {
            this.addDocuments([e]);
          }),
          (s.addDocuments = function (e) {
            (this._documents = this._documents.concat(e)),
              this.indexDocuments_(e, this._searchableFields);
          }),
          (s.addIndex = function (e) {
            this._searchableFields.push(e),
              this.indexDocuments_(this._documents, [e]);
          }),
          (s.search = function (e) {
            var t = this._tokenizer.tokenize(this._sanitizer.sanitize(e));
            return this._searchIndex.search(t, this._documents);
          }),
          (s.indexDocuments_ = function (e, t) {
            this._initialized = !0;
            for (
              var n = this._indexStrategy,
                s = this._sanitizer,
                a = this._searchIndex,
                i = this._tokenizer,
                r = this._uidFieldName,
                o = 0,
                l = e.length;
              o < l;
              o++
            ) {
              var u,
                c = e[o];
              u = r instanceof Array ? Ti(c, r) : c[r];
              for (var d = 0, m = t.length; d < m; d++) {
                var p,
                  _ = t[d];
                if (
                  (null != (p = _ instanceof Array ? Ti(c, _) : c[_]) &&
                    "string" != typeof p &&
                    p.toString &&
                    (p = p.toString()),
                  "string" == typeof p)
                )
                  for (
                    var h = i.tokenize(s.sanitize(p)), w = 0, g = h.length;
                    w < g;
                    w++
                  )
                    for (
                      var f = h[w], v = n.expandToken(f), y = 0, b = v.length;
                      y < b;
                      y++
                    ) {
                      var k = v[y];
                      a.indexDocument(k, u, c);
                    }
              }
            }
          }),
          (t = e),
          (n = [
            {
              key: "indexStrategy",
              set: function (e) {
                if (this._initialized)
                  throw Error(
                    "IIndexStrategy cannot be set after initialization"
                  );
                this._indexStrategy = e;
              },
              get: function () {
                return this._indexStrategy;
              },
            },
            {
              key: "sanitizer",
              set: function (e) {
                if (this._initialized)
                  throw Error("ISanitizer cannot be set after initialization");
                this._sanitizer = e;
              },
              get: function () {
                return this._sanitizer;
              },
            },
            {
              key: "searchIndex",
              set: function (e) {
                if (this._initialized)
                  throw Error(
                    "ISearchIndex cannot be set after initialization"
                  );
                this._searchIndex = e;
              },
              get: function () {
                return this._searchIndex;
              },
            },
            {
              key: "tokenizer",
              set: function (e) {
                if (this._initialized)
                  throw Error("ITokenizer cannot be set after initialization");
                this._tokenizer = e;
              },
              get: function () {
                return this._tokenizer;
              },
            },
          ]) && Fi(t.prototype, n),
          e
        );
      })();
      function Hi(e, t, n, s) {
        const a = e * (Math.PI / 180),
          i = t * (Math.PI / 180);
        return {
          x: 0,
          y: 0,
          wobble: 10 * s(),
          wobbleSpeed: 0.1 + 0.1 * s(),
          velocity: 0.5 * n + s() * n,
          angle2D: -a + (0.5 * i - s() * i),
          angle3D: -Math.PI / 4 + s() * (Math.PI / 2),
          tiltAngle: s() * Math.PI,
          tiltAngleSpeed: 0.1 + 0.3 * s(),
        };
      }
      const Bi = {
        angle: 90,
        spread: 45,
        startVelocity: 45,
        elementCount: 50,
        width: "10px",
        height: "10px",
        colors: ["#a864fd", "#29cdff", "#78ff44", "#ff718d", "#fdff6a"],
        duration: 3e3,
        stagger: 0,
        dragFriction: 0.1,
        random: Math.random,
      };
      function Ri(e, t = {}) {
        const {
            elementCount: n,
            colors: s,
            width: a,
            height: i,
            angle: r,
            spread: o,
            startVelocity: l,
            decay: u,
            dragFriction: c,
            duration: d,
            stagger: m,
            random: p,
          } = Object.assign(
            {},
            Bi,
            (function (e) {
              return !e.stagger && e.delay && (e.stagger = e.delay), e;
            })(t)
          ),
          _ = (function (e, t, n, s, a) {
            return Array.from({ length: t }).map((t, i) => {
              const r = document.createElement("div"),
                o = n[i % n.length];
              return (
                (r.style["background-color"] = o),
                (r.style.width = s),
                (r.style.height = a),
                (r.style.position = "absolute"),
                (r.style.willChange = "transform, opacity"),
                (r.style.visibility = "hidden"),
                e && e.appendChild(r),
                r
              );
            });
          })(e, n, s, a, i);
        return (function (e, t, n, s, a, i) {
          let r;
          return new Promise((o) => {
            requestAnimationFrame(function l(u) {
              r || (r = u);
              const c = u - r,
                d = r === u ? 0 : (u - r) / a;
              t.slice(0, Math.ceil(c / i)).forEach((e) => {
                !(function (e, t, n, s) {
                  (e.physics.x +=
                    Math.cos(e.physics.angle2D) * e.physics.velocity),
                    (e.physics.y +=
                      Math.sin(e.physics.angle2D) * e.physics.velocity),
                    (e.physics.z +=
                      Math.sin(e.physics.angle3D) * e.physics.velocity),
                    (e.physics.wobble += e.physics.wobbleSpeed),
                    s
                      ? (e.physics.velocity *= s)
                      : (e.physics.velocity -= e.physics.velocity * n),
                    (e.physics.y += 3),
                    (e.physics.tiltAngle += e.physics.tiltAngleSpeed);
                  const { x: a, y: i, tiltAngle: r, wobble: o } = e.physics,
                    l = `translate3d(${a + 10 * Math.cos(o)}px, ${
                      i + 10 * Math.sin(o)
                    }px, 0) rotate3d(1, 1, 1, ${r}rad)`;
                  (e.element.style.visibility = "visible"),
                    (e.element.style.transform = l),
                    (e.element.style.opacity = 1 - t);
                })(e, d, n, s);
              }),
                u - r < a
                  ? requestAnimationFrame(l)
                  : (t.forEach((t) => {
                      if (e && t.element.parentNode === e)
                        return e.removeChild(t.element);
                    }),
                    o());
            });
          });
        })(
          e,
          _.map((e) => ({ element: e, physics: Hi(r, o, l, p) })),
          c,
          u,
          d,
          m
        );
      }
      const {
          createElement: Ui,
          render: Ji,
          useState: Xi,
          useEffect: Wi,
          Fragment: Yi,
          useRef: Vi,
        } = wp.element,
        { dispatch: Qi, select: Ki } = wp.data,
        Gi = (e) => {
          const [t, n] = Xi(!1),
            [s, a] = Xi(!1),
            [i, r] = Xi(!1),
            o = Vi(null),
            l = Vi(null),
            [u, c] = Xi(!1),
            [m, p] = Xi(!1),
            [_, h] = Xi(""),
            [w, g] = Xi(!1),
            [f, y] = Xi(e.course),
            [b, k] = Xi({}),
            [q, x] = Xi({ prev: 0, next: 0 }),
            [N, z] = Xi(!1),
            [O, E] = Xi(!1),
            [P, I] = Xi({}),
            [C, M] = Xi(!1),
            [L, T] = Xi(!0),
            [A, D] = Xi(!0),
            [$, F] = Xi([]),
            [j, H] = Xi(null),
            [B, R] = Xi(!1),
            [U, J] = Xi(null),
            [X, W] = Xi(null),
            [Y, V] = Xi([]),
            [Q, K] = Xi([]),
            [Z, ee] = Xi([]),
            [te, ne] = Xi(!1);
          let se = Ki("vibebp").getUser();
          (se.token = Ki("vibebp").getToken()),
            Wi(() => {
              A
                ? document.querySelector(".vibebp_myprofile") &&
                  document
                    .querySelector(".vibebp_myprofile")
                    .classList.add("popup_active")
                : document.querySelector(".vibebp_myprofile") &&
                  document
                    .querySelector(".vibebp_myprofile")
                    .classList.remove("popup_active");
            }, [A]),
            Wi(() => {
              e.hasOwnProperty("download") &&
                e.download &&
                localforage.getItem("coursestatus_" + e.course_id).then((t) => {
                  if (t && t.length)
                    try {
                      (t = JSON.parse(t)), K(t);
                    } catch (e) {
                      console.log(e);
                    }
                  -1 == Y.indexOf(e.course_id) && V([...Y, e.course_id]);
                }),
                y(e.course);
            }, [e.course]),
            Wi(() => {
              f && ((e.hasOwnProperty("download") && e.download) || ie());
            }, [f]),
            Wi(() => {
              u &&
                (async () => {
                  if (!navigator.onLine)
                    return (
                      Qi("vibebp").addNotification({
                        text: window.wplms_course_data.translations
                          .could_not_refresh,
                      }),
                      await ge(1e3),
                      void c(!1)
                    );
                  b.hasOwnProperty("courseitems") &&
                  b.courseitems &&
                  b.courseitems.length
                    ? localforage
                        .removeItem(
                          `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}`
                        )
                        .then(() => {
                          b.courseitems.map((e, t) => {
                            let n = fe(e);
                            localforage.removeItem(n).then(async () => {
                              e.hasOwnProperty("id") &&
                                0 != e.id &&
                                (await Pe(
                                  `${window.wplms_course_data.api_url}/user/unitcomments/${e.id}`
                                )),
                                t == b.courseitems.length - 1 && ie(!0);
                            });
                          });
                        })
                    : localforage
                        .removeItem(
                          `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}`
                        )
                        .then(() => {
                          ie(!0);
                        });
                })();
            }, [u]),
            Wi(() => {
              (async () => {
                if (
                  (await ge(500),
                  document.querySelector(".course_package_wrapper") && !u)
                ) {
                  let e = new Draggabilly(
                    document.querySelector(".course_package_wrapper"),
                    { axis: "y", handle: ".course_package_header" }
                  );
                  e.on("dragStart", () => {}),
                    e.on("dragMove", (e, t, n) => {
                      n.y >= 90 && c(!0);
                    }),
                    e.on("dragEnd", () => {
                      e.setPosition(0, 0);
                    });
                } else if (document.querySelector(".course_content") && !u) {
                  let e = new Draggabilly(
                    document.querySelector(".course_content"),
                    { axis: "y", handle: ".course_content_header" }
                  );
                  e.on("dragStart", () => {}),
                    e.on("dragMove", (e, t, n) => {
                      n.y >= 90 && c(!0);
                    }),
                    e.on("dragEnd", () => {
                      e.setPosition(0, 0);
                    });
                }
              })();
            }, [u, b]),
            Wi(() => {
              Y.length &&
                localforage
                  .removeItem(
                    `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}`
                  )
                  .then(() => {
                    ie();
                  });
            }, [Y]),
            Wi(() => {
              if (
                Q.length &&
                Object.keys(b).length &&
                b.hasOwnProperty("courseitems") &&
                b.courseitems &&
                b.courseitems.length
              ) {
                let t = "coursestatus_" + e.course_id;
                localforage.setItem(t, JSON.stringify(Q));
                let n = X;
                for (let e = X + 1; e < b.courseitems.length; e++)
                  void 0 !== b.courseitems[e] &&
                    b.courseitems[e] &&
                    0 != b.courseitems[e].id &&
                    n <= X &&
                    (n = e);
                _e(n, { ...b }), (b.courseitems[X].downloaded = 1);
                let s = 0,
                  a = 0,
                  i = 0;
                b.courseitems.map((e, t) => {
                  e.downloaded && s++, e.id && i++;
                }),
                  (a = s / i),
                  (a = Math.round(100 * a)),
                  e.update({ progress: a, index: e.index }, "progresschanged");
              }
            }, [Q]),
            Wi(() => {
              localforage.setItem(
                "coursestatus_curriculum_item_video_urls_" + e.course_id,
                JSON.stringify(Z)
              );
            }, [Z]);
          const ae = (e) => {
            if (
              e.detail.hasOwnProperty("action") &&
              (console.log(e.detail), "unitfinished" == e.detail.action)
            ) {
              let t = e.detail.coursestatus.courseitems.findIndex(
                (t) => t.id == e.detail.id
              );
              t > -1 && xe(t);
            }
          };
          Wi(
            () => (
              document.addEventListener("custom_unit_action", ae),
              () => {
                document.removeEventListener("custom_unit_action", ae);
              }
            )
          ),
            Wi(
              () => (
                window.innerWidth < 480 && E(!0),
                document.addEventListener("wplms_change_coursestatus", (e) => {
                  let t = e.detail.coursestatus;
                  a(!0), k(t), a(!1);
                }),
                document.addEventListener("custom_quiz_action", (t) => {
                  if (t.detail.hasOwnProperty("action")) {
                    console.log(t.detail);
                    let n = t.detail.coursestatus;
                    if ("quizsubmitted" == t.detail.action) {
                      let s = n.courseitems.findIndex(
                        (e) => e.id == t.detail.id
                      );
                      if (s > -1) {
                        if (
                          n.courseitems[s].hasOwnProperty("status") &&
                          parseInt(n.courseitems[s].status)
                        )
                          return (n.courseitems[s].progressbar = 100), !1;
                        (n.courseitems[s].status = 1),
                          (n.courseitems[s].progressbar = 100);
                        let t = 0,
                          a = 0,
                          i = 0;
                        n.courseitems.map((e, n) => {
                          e.status && t++, e.id && i++;
                        }),
                          (a = t / i),
                          (a = Math.round(100 * a)),
                          e.update(
                            { progress: a, index: e.index },
                            "progresschanged"
                          ),
                          k(n),
                          n.courseitems[s] && "unit" == n.courseitems[s].type
                            ? fetch(
                                `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}/item/${n.courseitems[s].id}/markcomplete?post`,
                                {
                                  method: "post",
                                  headers: window.vibebp.xnonce
                                    ? { "X-WP-Nonce": window.vibebp.xnonce }
                                    : {},
                                  body: JSON.stringify({
                                    token: se.token,
                                    progress: a,
                                  }),
                                }
                              )
                                .then((e) =>
                                  e.ok
                                    ? e.json()
                                    : {
                                        status: 0,
                                        message:
                                          window.wplms_course_data.translations
                                            .error_loading_data,
                                      }
                                )
                                .then((t) => {
                                  t &&
                                    (t.status
                                      ? (Qi("vibebp").addNotification({
                                          icon: t.icon,
                                          text: t.message,
                                        }),
                                        a && a >= 100 && de(),
                                        document.dispatchEvent(
                                          new CustomEvent(
                                            "course_item_completed",
                                            {
                                              detail: {
                                                course_id: e.course_id,
                                                item_id: n.courseitems[s].id,
                                              },
                                            }
                                          )
                                        ))
                                      : t.hasOwnProperty("message") &&
                                        Qi("vibebp").addNotification({
                                          text: t.message,
                                        }),
                                    le(n, X));
                                })
                                .catch((e) => {
                                  console.error("Uh oh, an error!", e),
                                    Qi("vibebp").addNotification({
                                      text: window.wplms_course_data
                                        .translations.error_loading_data,
                                    });
                                })
                            : ((n.courseitems[s].status = 1),
                              k(n),
                              a && a >= 100 && de(),
                              document.dispatchEvent(
                                new CustomEvent("course_item_completed", {
                                  detail: {
                                    course_id: e.course_id,
                                    item_id: n.courseitems[s].id,
                                  },
                                })
                              )),
                          le(n, s);
                      }
                    }
                    if ("retake_quiz" == t.detail.action) {
                      let t = n.current_unit_key;
                      if (n.courseitems[t] && n.courseitems[t].status) {
                        n.courseitems[t].status = 0;
                        let s = 0,
                          a = 0,
                          i = 0;
                        n.courseitems.map((e, t) => {
                          e.status && s++, e.id && i++;
                        }),
                          (a = s / i),
                          (a = Math.round(100 * a)),
                          e.update(
                            { progress: a, index: e.index },
                            "progresschanged"
                          ),
                          k(n),
                          le(n, t),
                          new CustomEvent("item_retake", {
                            detail: {
                              coursestatus: { ...b },
                              item_id: b.courseitems[t].id,
                              course_id: e.course_id,
                            },
                          });
                      }
                    }
                  }
                }),
                (e.hasOwnProperty("download") && e.download) ||
                  (document
                    .querySelector("body")
                    .classList.add("course_status_fullscreen"),
                  document
                    .querySelector("body")
                    .classList.add("wplms_course_status")),
                window.wplms_course_data.disable_contextmenu &&
                  document.addEventListener("contextmenu", ue, !1),
                () => {
                  if (
                    (document
                      .querySelector("body")
                      .classList.remove("wplms_course_status"),
                    document
                      .querySelector("body")
                      .classList.remove("course_status_fullscreen"),
                    document
                      .querySelector("body")
                      .classList.remove("course_status_loaded"),
                    Y.indexOf(e.course_id) > -1)
                  ) {
                    let t = [...Y];
                    t.splice(Y.indexOf(e.course_id), 1), V(t);
                  }
                  window.wplms_course_data.disable_contextmenu &&
                    document.removeEventListener("contextmenu", ue);
                  var t = new CustomEvent("course_status_left", {
                    detail: { coursestatus: b, course_id: e.course_id },
                  });
                  document.dispatchEvent(t);
                }
              ),
              []
            ),
            Wi(() => {
              let e = { ...b };
              if (_ && _.length > 3) {
                if (e && e.courseitems) {
                  var t = new ji("key");
                  t.addIndex("title"),
                    t.addIndex("content"),
                    t.addDocuments(e.courseitems);
                  var n = t.search(_);
                  (e.filtered_items = n),
                    (e.keyword = _),
                    k(e),
                    n && n.length && _e(n[0].key, e);
                }
              } else (e.filtered_items = []), (e.keyword = ""), k(e);
            }, [_]);
          const ie = (t) => {
            t || n(!0),
              p(!1),
              ce(e.course_id),
              fetch(
                `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}`,
                {
                  method: "post",
                  headers: window.vibebp.xnonce
                    ? { "X-WP-Nonce": window.vibebp.xnonce }
                    : {},
                  body: JSON.stringify({ token: se.token }),
                }
              )
                .then((e) =>
                  e.ok
                    ? e.json()
                    : {
                        status: 0,
                        message:
                          window.wplms_course_data.translations
                            .error_loading_data,
                      }
                )
                .then(async (s) => {
                  if (s) {
                    s.hasOwnProperty("error_code") &&
                      (Qi("vibebp").addNotification({
                        icon: s.icon,
                        text:
                          s.hasOwnProperty("error_message") &&
                          s.error_message.length
                            ? s.error_message
                            : window.wplms_course_data.translations.error,
                      }),
                      e.back(!0));
                    let r = null,
                      o = [],
                      l = null;
                    if (s.courseitems && s.courseitems.length)
                      if (
                        (s.courseitems.map((t, n) => {
                          t.status && ((t.progressbar = 100), D(!1)),
                            t.hasOwnProperty("id") &&
                              0 != s.courseitems[n].id &&
                              (null === r && ((r = n), (l = n)),
                              o.push(fe(s.courseitems[n])),
                              e.hasOwnProperty("startUnit") &&
                                e.startUnit &&
                                parseInt(s.courseitems[n].id) ===
                                  parseInt(e.startUnit) &&
                                (r = n));
                        }),
                        document
                          .querySelector("body")
                          .classList.contains("course_status_loaded") ||
                          document
                            .querySelector("body")
                            .classList.add("course_status_loaded"),
                        e.hasOwnProperty("download") &&
                          e.download &&
                          Y.indexOf(e.course_id) > -1)
                      ) {
                        if (
                          (localforage.setItem(
                            "coursestatus_curriculum_item_urls_" + e.course_id,
                            JSON.stringify(o)
                          ),
                          e.hasOwnProperty("startUnit") &&
                            e.startUnit &&
                            l !== r)
                        )
                          for (var a = 0; a < r; a++)
                            void 0 !== s.courseitems[a] &&
                              s.courseitems[a] &&
                              0 != s.courseitems[a].id &&
                              (s.courseitems[a].downloaded = 1);
                        (s.current_unit_key = r),
                          k(s),
                          W(r),
                          _e(r, s),
                          ye(s.current_unit_key, s);
                      } else
                        k(s),
                          W(s.current_unit_key),
                          _e(s.current_unit_key, s),
                          ye(s.current_unit_key, s);
                    if (s.hasOwnProperty("package") && s.package.length)
                      if (
                        (p(!0),
                        s.hasOwnProperty("package_details") &&
                          s.package_details &&
                          s.package_details.hasOwnProperty("package_type") &&
                          "xapi" == s.package_details.package_type)
                      ) {
                        let t = s.package_details.path;
                        (t +=
                          "?endpoint=" +
                          encodeURIComponent(
                            window.wplms_course_data.xapi_endpoint +
                              "/" +
                              e.course_id
                          )),
                          (t +=
                            "&auth=" + encodeURIComponent("Basic " + se.token)),
                          (t +=
                            "&actor=" +
                            encodeURIComponent(
                              JSON.stringify({
                                objectType: "Agent",
                                mbox: se.email,
                                name: se.displayname,
                              })
                            )),
                          k({
                            package:
                              '<div class="iframecontent"><iframe src="' +
                              t +
                              '" width="100%" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div>',
                          });
                      } else
                        (window.scorm_page_type = "course"),
                          (window.scorm_wplms_data = {}),
                          (window.scorm_wplms_data.user_email = se.email),
                          (window.scorm_wplms_data.user_name = se.username),
                          (window.scorm_wplms_data.token = se.token),
                          (window.scorm_wplms_data.course_id = e.course_id),
                          (window.is_take_course = !0),
                          (window.scorm_wplms_data.type = "course"),
                          k({ package: s.package }),
                          s.hasOwnProperty("package_type") &&
                            s.package_type &&
                            "1.1" == s.package_type &&
                            setTimeout(() => {
                              var e = new CustomEvent("unit_content_loaded", {
                                detail: {
                                  coursestatus: { package: s.package },
                                },
                              });
                              document.dispatchEvent(e);
                            }, 200);
                    var i = new CustomEvent("course_status_loaded", {
                      detail: { coursestatus: s, course_id: e.course_id },
                    });
                    document.dispatchEvent(i), t || n(!1);
                  }
                  t && (await ge(500), c(!1));
                })
                .catch((e) => {
                  c(!1),
                    console.error("Uh oh, an error!", e),
                    Qi("vibebp").addNotification({
                      text: window.wplms_course_data.translations
                        .error_loading_data,
                    });
                });
          };
          Wi(() => {
            if (b)
              return (
                document.addEventListener("course_item_completed", re),
                () => {
                  document.removeEventListener("course_item_completed", re);
                }
              );
          }, [b]);
          const re = (e) => {
              e.detail &&
                e.detail.course_id &&
                e.detail.item_id &&
                oe(e.detail.course_id, e.detail.item_id);
            },
            oe = (e, t) => {
              b.hasOwnProperty("gamification") &&
                b.gamification.type &&
                "curriculum" == b.gamification.type &&
                b.gamification.value &&
                b.gamification.value.hasOwnProperty(t) &&
                fetch(
                  `${window.wplms_course_data.api_url}/user/coursestatus/${e}/item/${t}/assignbadges?post`,
                  {
                    method: "post",
                    headers: window.vibebp.xnonce
                      ? { "X-WP-Nonce": window.vibebp.xnonce }
                      : {},
                    body: JSON.stringify({ token: se.token }),
                  }
                )
                  .then((e) =>
                    e.ok
                      ? e.json()
                      : {
                          status: 0,
                          message:
                            window.wplms_course_data.translations
                              .error_loading_data,
                        }
                  )
                  .then((e) => {
                    e.status &&
                      (e.hasOwnProperty("message") &&
                        Qi("vibebp").addNotification({
                          iconUrl: window.wplms_course_data.coin_image,
                          backgroundColor: "var(--success)",
                          textColor: "var(--gray-dark)",
                          text: e.message,
                        }),
                      e.hasOwnProperty("badges") &&
                        Array.isArray(e.badges) &&
                        e.badges.length &&
                        (ne(!0),
                        setTimeout(() => {
                          ne(!1);
                        }, 5e3),
                        iziToast
                          ? e.badges.map((e) => {
                              iziToast.show({
                                message: `${window.wplms_course_data.translations.you_have_got_badge} ${e.name}`,
                                image: e.image,
                                position: "topCenter",
                              });
                            })
                          : e.badges.map((e) => {
                              Qi("vibebp").addNotification({
                                text: `${window.wplms_course_data.translations.you_have_got_badge} ${e.name}`,
                              });
                            })));
                  })
                  .catch((e) => {
                    console.error("Uh oh, an error!", e),
                      Qi("vibebp").addNotification({
                        text: window.wplms_course_data.translations
                          .error_loading_data,
                      });
                  });
            },
            le = (t, n) => {
              "undefined" != typeof localforage &&
                window.vibebp.api.sw_enabled &&
                localforage
                  .getItem(
                    `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}`
                  )
                  .then((s) => {
                    s &&
                      s.length &&
                      (s = JSON.parse(s)).hasOwnProperty("courseitems") &&
                      ((s.courseitems = t.courseitems),
                      (s.current_unit_key = n),
                      localforage.setItem(
                        `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}`,
                        JSON.stringify(s)
                      ));
                  });
            },
            ue = (e) => (
              console.log("You've tried to open context menu"),
              e.preventDefault(),
              !1
            ),
            ce = (e) => {
              window.wplms_course_data.gamification &&
                window.wplms_course_data.gamification &&
                fetch(
                  `${window.wplms_course_data.api_url}/user/coursestatus/${e}/gamification`,
                  {
                    method: "post",
                    headers: window.vibebp.xnonce
                      ? { "X-WP-Nonce": window.vibebp.xnonce }
                      : {},
                    body: JSON.stringify({ token: se.token }),
                  }
                )
                  .then((e) =>
                    e.ok
                      ? e.json()
                      : {
                          status: 0,
                          message:
                            window.wplms_course_data.translations
                              .error_loading_data,
                        }
                  )
                  .then((e) => {
                    e.status &&
                      e.active &&
                      e.gamification &&
                      (k((t) => ({ ...t, gamification: e.gamification })),
                      Qi("vibebp").addNotification({ text: e.message }));
                  })
                  .catch((e) => {
                    console.error("Uh oh, an error!", e),
                      Qi("vibebp").addNotification({
                        text: window.wplms_course_data.translations
                          .error_loading_data,
                      });
                  });
            },
            de = () => {
              (e.hasOwnProperty("download") && e.download) ||
                (b.hasOwnProperty("auto_finish") &&
                  b.auto_finish &&
                  f.user_progress >= 100 &&
                  fetch(
                    `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}/checkcomplete`,
                    {
                      method: "post",
                      headers: window.vibebp.xnonce
                        ? { "X-WP-Nonce": window.vibebp.xnonce }
                        : {},
                      body: JSON.stringify({
                        token: se.token,
                        course: b,
                        course_id: e.course,
                      }),
                    }
                  )
                    .then((e) =>
                      e.ok
                        ? e.json()
                        : {
                            status: 0,
                            message:
                              window.wplms_course_data.translations
                                .error_loading_data,
                          }
                    )
                    .then((e) => {
                      e && e.status && ze(!0);
                    })
                    .catch((e) => {
                      console.error("Uh oh, an error!", e),
                        Qi("vibebp").addNotification({
                          text: window.wplms_course_data.translations
                            .error_loading_data,
                        });
                    }));
            },
            me = (e) => {
              let t = { ...b };
              t &&
                t.courseitems &&
                t.courseitems[X] &&
                "unit" == t.courseitems[X].type &&
                (t.courseitems[X].hasOwnProperty("progressbar") ||
                  (t.courseitems[X].progressbar = 0),
                e > 100 && (e = 100),
                (t.courseitems[X].progressbar = e),
                k(t));
            },
            pe = (e, t) => {
              let n = document.scrollingElement || document.documentElement;
              document.querySelector("body").classList &&
                document.querySelector("body").classList.length &&
                document
                  .querySelector("body")
                  .classList.contains("course_status_fullscreen") &&
                o.current &&
                ((e = 0), (n = o.current));
              const s = n.scrollTop,
                a = e - s,
                i = +new Date(),
                r = function () {
                  const o = +new Date() - i;
                  var l, u, c;
                  (n.scrollTop = parseInt(
                    ((l = o),
                    (u = s),
                    (c = a),
                    (l /= t / 2) < 1
                      ? (c / 2) * l * l + u
                      : (-c / 2) * (--l * (l - 2) - 1) + u)
                  )),
                    o < t ? requestAnimationFrame(r) : (n.scrollTop = e);
                };
              r();
            },
            _e = async (t, n = null, s = null) => {
              if (
                (null == n && (n = { ...b }),
                n.hasOwnProperty("lock") &&
                  n.lock &&
                  (!e.hasOwnProperty("download") || !e.download) &&
                  n.courseitems &&
                  n.courseitems.length)
              )
                for (let e = 0; e < t; e++)
                  if (
                    "section" != n.courseitems[e].type &&
                    !n.courseitems[e].status
                  )
                    return !1;
              if (n.courseitems[t].id && "unit" == n.courseitems[t].type)
                if (
                  s ||
                  !n.courseitems[t].content ||
                  n.courseitems[t].content.length < 3 ||
                  !n.courseitems[t].meta.hasOwnProperty("access") ||
                  !n.courseitems[t].meta.access ||
                  (n.courseitems[t].meta.hasOwnProperty("no_cache") &&
                    n.courseitems[t].meta.no_cache)
                ) {
                  a(!0), U && U.abort();
                  let i = {},
                    r = new AbortController();
                  U && (i = { signal: r.signal }),
                    J(r),
                    (n.current_unit_key = t),
                    W(t),
                    k(n),
                    ye(t, n);
                  let l = `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}/item/${n.courseitems[t].id}`;
                  (s ||
                    (n.courseitems[t].meta.hasOwnProperty("no_cache") &&
                      n.courseitems[t].meta.no_cache)) &&
                    (l += "?force"),
                    fetch(l, {
                      method: "post",
                      headers: window.vibebp.xnonce
                        ? { "X-WP-Nonce": window.vibebp.xnonce }
                        : {},
                      ...i,
                      body: JSON.stringify({ token: se.token }),
                    })
                      .then((e) => e.json())
                      .then(async (s) => {
                        if ((J(null), s)) {
                          (n.courseitems[t].content = s.content),
                            (n.courseitems[t].meta = s.meta);
                          let r = 1;
                          Array.isArray(s.scripts) &&
                            s.scripts.map((e) => {
                              if (!document.getElementById(e.key)) {
                                let t = document.createElement("script");
                                (t.src = e.src),
                                  (t.id = e.key),
                                  document.body.appendChild(t),
                                  (t.onload = () => {
                                    r++,
                                      console.log("loaded"),
                                      r == s.scripts.length &&
                                        document.body.dispatchEvent(
                                          new Event("post-load")
                                        );
                                  });
                              }
                            }),
                            k(n),
                            le(n, t),
                            a(!1),
                            document.querySelector(".course_status") &&
                              document
                                .querySelector(".course_status")
                                .scroll({
                                  top: o.current.getBoundingClientRect().top,
                                  left: 0,
                                  behavior: "smooth",
                                }),
                            s.meta.hasOwnProperty("scorm_type") &&
                              s.meta.scorm_type &&
                              setTimeout(() => {
                                var e = new CustomEvent("unit_content_loaded", {
                                  detail: { coursestatus: n },
                                });
                                document.dispatchEvent(e);
                              }, 200);
                          var i = new CustomEvent("unit_loaded", {
                            detail: {
                              coursestatus: n,
                              course: e.course_id,
                              user: Ki("vibebp").getUser(),
                              currentUnitKey: t,
                            },
                          });
                          if (
                            (document.dispatchEvent(i),
                            document.dispatchEvent(
                              new Event("VibeBP_Editor_Content")
                            ),
                            e.hasOwnProperty("download") &&
                              e.download &&
                              Y.indexOf(e.course_id) > -1)
                          ) {
                            await ge(4e3), await he(n.courseitems[t]);
                            let e = fe(n.courseitems[t]);
                            K([...Q, e]);
                          }
                        }
                      })
                      .catch((e) => {
                        "AbortError" === e.name
                          ? console.log("Fetch aborted")
                          : (J(null),
                            a(!1),
                            console.error("Uh oh, an error!", e),
                            Qi("vibebp").addNotification({
                              text: window.wplms_course_data.translations
                                .error_loading_data,
                            }));
                      });
                } else {
                  W(t),
                    (n.current_unit_key = t),
                    k(n),
                    le(n, t),
                    ye(t, n),
                    n.hasOwnProperty("courseitems") &&
                      n.courseitems[t] &&
                      n.courseitems[t].hasOwnProperty("meta") &&
                      n.courseitems[t].meta.hasOwnProperty("scorm_type") &&
                      n.courseitems[t].meta.scorm_type &&
                      setTimeout(() => {
                        var e = new CustomEvent("unit_content_loaded", {
                          detail: { coursestatus: n },
                        });
                        document.dispatchEvent(e);
                      }, 200),
                    document.querySelector(".course_status") &&
                      document
                        .querySelector(".course_status")
                        .scroll({
                          top: o.current.getBoundingClientRect().top,
                          left: 0,
                          behavior: "smooth",
                        });
                  var i = new CustomEvent("unit_loaded", {
                    detail: {
                      coursestatus: n,
                      course: e.course_id,
                      currentUnitKey: t,
                      user: Ki("vibebp").getUser(),
                    },
                  });
                  document.dispatchEvent(i),
                    document.dispatchEvent(new Event("VibeBP_Editor_Content")),
                    (e.hasOwnProperty("download") && e.download) ||
                      (o.current &&
                        window.hasOwnProperty("innerWidth") &&
                        window.innerWidth > 768 &&
                        pe(o.current.scrollTop, 800));
                }
              else {
                if (
                  (a(!0),
                  W(t),
                  (n.current_unit_key = t),
                  k(n),
                  ye(t, n),
                  a(!1),
                  le(n, t),
                  (e.hasOwnProperty("download") && e.download) ||
                    (o.current &&
                      window.hasOwnProperty("innerWidth") &&
                      window.innerWidth > 768 &&
                      pe(o.current.scrollTop, 800)),
                  e.hasOwnProperty("download") &&
                    e.download &&
                    Y.indexOf(e.course_id) > -1)
                ) {
                  await ge(4e3), await he(n.courseitems[t]);
                  let e = fe(n.courseitems[t]);
                  K([...Q, e]);
                }
                document.querySelector(".course_status") &&
                  document
                    .querySelector(".course_status")
                    .scroll({
                      top: o.current.getBoundingClientRect().top,
                      left: 0,
                      behavior: "smooth",
                    });
              }
              r(!1);
            },
            he = async (e) =>
              new Promise(async (t, n) => {
                if (e.meta.hasOwnProperty("video"))
                  if (
                    "object" == typeof e.meta.video &&
                    "video" == e.meta.video.type
                  )
                    await we(e.meta.video.url), t();
                  else if (Array.isArray(e.meta.video) && e.meta.video.length)
                    for (let n = 0; n < e.meta.video.length; n++)
                      console.log(e.meta.video[n]),
                        await we(e.meta.video[n]),
                        e.meta.video.length - 1 === n && t();
                  else t();
                else if (e.meta.hasOwnProperty("audio"))
                  if (
                    "object" == typeof e.meta.audio &&
                    "audio" == e.meta.audio.type
                  )
                    await we(e.meta.audio.url), t();
                  else if (Array.isArray(e.meta.audio) && e.meta.audio.length)
                    for (let n = 0; n < e.meta.audio.length; n++)
                      await we(e.meta.audio[n]),
                        e.meta.audio.length - 1 === n && t();
                  else t();
                else t();
              }),
            we = async (t, n = null) =>
              new Promise(async (s, a) => {
                fetch(t)
                  .then((e) => e.blob())
                  .then((e) => {
                    n && (t = n),
                      localforage.setItem(t, e),
                      Z.indexOf(t) < 0 && ee([...Z, t]),
                      s(t);
                  })
                  .catch((t) => {
                    console.log(t),
                      Qi("vibebp").addNotification({
                        text: window.wplms_course_data.translations
                          .some_error_downloading_video,
                      }),
                      e.update("", "pause");
                  });
              }),
            ge = (e) => new Promise((t) => setTimeout(t, e)),
            fe = (t) => {
              let n = "";
              console.log("Fourth" + t.id);
              return (
                (n =
                  "unit" == t.type
                    ? `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}/item/${t.id}`
                    : "quiz" == t.type
                    ? `${window.wplms_course_data.api_url}/user/quiz/${t.id}`
                    : "wplms-assignment" == t.type
                    ? `${window.wplms_course_data.api_url}/user/content/assignmentId/${t.id}`
                    : `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}/item/${t.id}`),
                n
              );
            },
            ve = (t) => {
              let n = X;
              if ("prev" == t) {
                for (let e = n - 1; e >= 0; e--)
                  if (b.courseitems[e] && 0 != b.courseitems[e].id) {
                    n = b.courseitems[e].key;
                    break;
                  }
              } else
                for (let t = n + 1; t < b.courseitems.length; t++)
                  if (b.courseitems[t] && 0 != b.courseitems[t].id) {
                    (n = b.courseitems[t].key),
                      1 == e.course.user_status &&
                        e.update(
                          { index: e.index, user_status: 2 },
                          "statuschanged"
                        );
                    break;
                  }
              _e(n);
            },
            ye = (e, t = null) => {
              null === t && (t = b);
              let n = { prev: 0, next: 0 };
              for (let s = e - 1; s >= 0; s--)
                if (t.courseitems[s] && 0 != t.courseitems[s].id) {
                  n.prev = 1;
                  break;
                }
              for (let s = e + 1; s < t.courseitems.length; s++)
                if (t.courseitems[s] && 0 != t.courseitems[s].id) {
                  n.next = 1;
                  break;
                }
              x(n);
            },
            be = (t = null, n = null) => {
              if (("quizsubmitted" == t && xe(), "retake_quiz" == t)) {
                let t = { ...b };
                if (t.courseitems[X] && t.courseitems[X].status) {
                  (t.courseitems[X].status = 0),
                    (t.courseitems[X].user_marks = 0),
                    (t.courseitems[X].total_marks = 0);
                  let n = 0,
                    a = 0,
                    i = 0;
                  t.courseitems.map((e, t) => {
                    e.status && n++, e.id && i++;
                  }),
                    (a = n / i),
                    (a = Math.round(100 * a)),
                    e.update(
                      { progress: a, index: e.index },
                      "progresschanged"
                    ),
                    k(t),
                    le(t, X);
                  var s = new CustomEvent("item_retake", {
                    detail: {
                      coursestatus: { ...b },
                      item_id: b.courseitems[X].id,
                      course_id: e.course_id,
                    },
                  });
                  document.dispatchEvent(s);
                }
              }
              if ("update_quiz_marks" == t) {
                let e = { ...b },
                  t = { ...e.courseitems[X] };
                t.hasOwnProperty("user_marks") || (t.user_marks = 0),
                  t.hasOwnProperty("total_marks") || (t.total_marks = 0),
                  (t.user_marks += parseInt(n.user_marks)),
                  (t.total_marks += parseInt(n.total_marks)),
                  (e.courseitems[X] = t),
                  k(e);
              }
            },
            ke = (t, n) => {
              let s = { ...b };
              "submitassignment" == n &&
                (t.hasOwnProperty("unitIndex") ||
                  ((s.courseitems[X].status = 1),
                  k(s),
                  le(s, X),
                  document.dispatchEvent(
                    new CustomEvent("course_item_completed", {
                      detail: {
                        course_id: e.course_id,
                        item_id: b.courseitems[X].id,
                        courseStatus: { ...b },
                      },
                    })
                  ))),
                "retookassignment" == n &&
                  (t.hasOwnProperty("unitIndex") ||
                    ((s.courseitems[X].status = 0),
                    k(s),
                    le(s, X),
                    document.dispatchEvent(
                      new CustomEvent("item_retake", {
                        detail: {
                          course_id: e.course_id,
                          item_id: b.courseitems[X].id,
                          courseStatus: { ...b },
                        },
                      })
                    )));
            },
            qe = (e) =>
              Ri(e, {
                colors: ["#a864fd", "#29cdff", "#78ff44", "#ff718d", "#fdff6a"],
                angle: 90,
                spread: 90,
                startVelocity: 45,
                elementCount: 100,
                dragFriction: 0.1,
                duration: 5e3,
                stagger: 2,
                width: "12px",
                height: "12px",
              }),
            xe = (t = null, n = null) =>
              new Promise((s) => {
                e.hasOwnProperty("download") && e.download && s();
                let a = { ...b };
                if (
                  (null == t && (t = X),
                  a.courseitems[t].hasOwnProperty("status") &&
                    parseInt(a.courseitems[t].status))
                )
                  return (a.courseitems[t].progressbar = 100), s(), !1;
                (a.courseitems[t].status = 1),
                  (a.courseitems[t].progressbar = 100);
                let i = 0,
                  r = 0,
                  o = 0;
                a.courseitems.map((e, t) => {
                  e.status && i++, e.id && o++;
                }),
                  (r = i / o),
                  (r = Math.round(100 * r)),
                  e.update({ progress: r, index: e.index }, "progresschanged"),
                  a.courseitems[t] && "unit" == a.courseitems[t].type
                    ? fetch(
                        `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}/item/${a.courseitems[t].id}/markcomplete?post`,
                        {
                          method: "post",
                          headers: window.vibebp.xnonce
                            ? { "X-WP-Nonce": window.vibebp.xnonce }
                            : {},
                          body: JSON.stringify({
                            token: se.token,
                            progress: r,
                          }),
                        }
                      )
                        .then((e) =>
                          e.ok
                            ? e.json()
                            : {
                                status: 0,
                                message:
                                  window.wplms_course_data.translations
                                    .error_loading_data,
                              }
                        )
                        .then((i) => {
                          i &&
                            (i.status &&
                              (r && r >= 100 && null == n && de(),
                              document.dispatchEvent(
                                new CustomEvent("course_item_completed", {
                                  detail: {
                                    course_id: e.course_id,
                                    item_id: a.courseitems[t].id,
                                    courseStatus: a,
                                  },
                                })
                              )),
                            Qi("vibebp").addNotification({
                              icon: i.icon,
                              text: i.message,
                            }),
                            k(a),
                            le(a, X),
                            s());
                        })
                        .catch((e) => {
                          console.error("Uh oh, an error!", e),
                            Qi("vibebp").addNotification({
                              text: window.wplms_course_data.translations
                                .error_loading_data,
                            });
                        })
                    : ((a.courseitems[t].status = 1),
                      k(a),
                      r && r >= 100 && null == n && de(),
                      document.dispatchEvent(
                        new CustomEvent("course_item_completed", {
                          detail: {
                            course_id: e.course_id,
                            item_id: a.courseitems[t].id,
                            courseStatus: a,
                          },
                        })
                      ),
                      k(a),
                      le(a, t),
                      s());
              }),
            Ne = () => {
              if (
                ((b.hasOwnProperty("package") && b.package) || xe(),
                M(!0),
                R(!0),
                !b.hasOwnProperty("comments_open") || !b.comments_open)
              )
                return ze(!0), !1;
              P.hasOwnProperty("comment_ID") ||
                fetch(
                  `${window.wplms_course_data.api_url}/user/getreview/${e.course_id}`,
                  {
                    method: "post",
                    headers: window.vibebp.xnonce
                      ? { "X-WP-Nonce": window.vibebp.xnonce }
                      : {},
                    body: JSON.stringify({
                      token: se.token,
                      course_id: e.course_id,
                    }),
                  }
                )
                  .then((e) =>
                    e.ok
                      ? e.json()
                      : {
                          status: 0,
                          message:
                            window.wplms_course_data.translations
                              .error_loading_data,
                        }
                  )
                  .then((e) => {
                    e && e.comment_ID && I(e), T(!1);
                  })
                  .catch((e) => {
                    T(!1),
                      console.error("Uh oh, an error!", e),
                      Qi("vibebp").addNotification({
                        text: window.wplms_course_data.translations
                          .error_loading_data,
                      });
                  });
            },
            ze = (t = null) => {
              if (!t) {
                if (
                  !(
                    P &&
                    P.hasOwnProperty("title") &&
                    P.hasOwnProperty("review") &&
                    P.hasOwnProperty("rating") &&
                    P.title.length > 3 &&
                    P.review.length > 3 &&
                    P.rating >= 1
                  )
                )
                  return (
                    alert(
                      window.wplms_course_data.translations
                        .please_check_review_form
                    ),
                    T(!1),
                    !1
                  );
                T(!0),
                  (P.comment_post_ID = e.course_id),
                  (P.course_id = e.course_id),
                  (P.token = se.token),
                  fetch(
                    `${window.wplms_course_data.api_url}/updatecourse/addreview?post`,
                    {
                      method: "post",
                      headers: window.vibebp.xnonce
                        ? { "X-WP-Nonce": window.vibebp.xnonce }
                        : {},
                      body: JSON.stringify(P),
                    }
                  )
                    .then((e) =>
                      e.ok
                        ? e.json()
                        : {
                            status: 0,
                            message:
                              window.wplms_course_data.translations
                                .error_loading_data,
                          }
                    )
                    .then((t) => {
                      if (!t)
                        return (
                          alert(
                            window.wplms_course_data.translations
                              .error_review_form
                          ),
                          T(!1),
                          !1
                        );
                      if (t.status)
                        T(!1),
                          t.hasOwnProperty("comment_id") &&
                            t.comment_id &&
                            "undefined" != typeof localforage &&
                            window.vibebp.api.sw_enabled &&
                            localforage
                              .getItem(
                                `${window.wplms_course_data.api_url}/user/getreview/${e.course_id}`
                              )
                              .then((n) => {
                                n &&
                                  n.length &&
                                  "object" == typeof (n = JSON.parse(n)) &&
                                  ((n.comment_ID = t.comment_id),
                                  (n.rating = P.rating),
                                  (n.review = P.review),
                                  (n.title = P.title),
                                  localforage.setItem(
                                    `${window.wplms_course_data.api_url}/user/getreview/${e.course_id}`,
                                    JSON.stringify(n)
                                  ));
                              });
                      else if (t.message) return alert(t.message), T(!1), !1;
                    })
                    .catch((e) => {
                      T(!1),
                        console.error("Uh oh, an error!", e),
                        Qi("vibebp").addNotification({
                          text: window.wplms_course_data.translations
                            .error_loading_data,
                        });
                    });
              }
              T(!0),
                fetch(
                  `${window.wplms_course_data.api_url}/user/finishcourse?post`,
                  {
                    method: "post",
                    headers: window.vibebp.xnonce
                      ? { "X-WP-Nonce": window.vibebp.xnonce }
                      : {},
                    body: JSON.stringify({
                      course_id: e.course_id,
                      token: se.token,
                    }),
                  }
                )
                  .then((e) =>
                    e.ok
                      ? e.json()
                      : {
                          status: 0,
                          message:
                            window.wplms_course_data.translations
                              .error_loading_data,
                        }
                  )
                  .then((t) => {
                    if (t) {
                      if (t.status && (M(!1), T(!1), t.finished)) {
                        if (
                          (H(t.finished),
                          t.finished.hasOwnProperty("course_status"))
                        ) {
                          e.update(
                            {
                              index: e.index,
                              user_status: t.finished.course_status,
                            },
                            "statuschanged"
                          );
                          let n = { ...b };
                          (n.course_status = t.finished.course_status), k(n);
                        }
                        t.finished.status &&
                          Oe().then(() => {
                            e.update(
                              { progress: 100, index: e.index },
                              "progresschanged"
                            ),
                              "undefined" != typeof localforage &&
                                window.vibebp.api.sw_enabled &&
                                localforage
                                  .getItem(
                                    `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}`
                                  )
                                  .then((t) => {
                                    t &&
                                      t.length &&
                                      ((t = b),
                                      localforage.setItem(
                                        `${window.wplms_course_data.api_url}/user/coursestatus/${e.course_id}`,
                                        JSON.stringify(t)
                                      ));
                                  });
                          });
                      }
                    } else
                      Qi("vibebp").addNotification({
                        text: window.wplms_course_data.translations
                          .error_finishing_course,
                      }),
                        T(!1);
                  })
                  .catch((e) => {
                    T(!1),
                      console.error("Uh oh, an error!", e),
                      Qi("vibebp").addNotification({
                        text: window.wplms_course_data.translations
                          .error_loading_data,
                      });
                  });
            },
            Oe = () => {
              let e = [],
                t = { ...b };
              return (
                t.hasOwnProperty("courseitems") &&
                  t.courseitems &&
                  t.courseitems.length &&
                  t.courseitems.map((n, s) => {
                    let a = new Promise(function (e) {
                      n && n.hasOwnProperty("status") && parseInt(n.status)
                        ? e()
                        : n && n.hasOwnProperty("id") && parseInt(n.id)
                        ? ((t.courseitems[s].status = 1),
                          (t.courseitems[s].progressbar = 100),
                          e())
                        : e();
                    });
                    e.push(a);
                  }),
                k(t),
                Promise.all(e)
              );
            },
            Se = (e, t) => {
              if (
                ("loadunit" == t &&
                  e.hasOwnProperty("index") &&
                  _e(e.index, null, !0),
                (b.hasOwnProperty("assignment_locking") &&
                  b.assignment_locking &&
                  "completeUnitAssigmnent" == t) ||
                  "retakeUnitAssigmnent" == t)
              ) {
                let n = { ...b },
                  s = n.courseitems[X];
                if (parseInt(n.assignment_locking) > 1) {
                  if (
                    ("completeUnitAssigmnent" == t &&
                      s.meta.hasOwnProperty("assignments") &&
                      s.meta.assignments.length &&
                      (s.meta.assignments[e.assignmentIndex].status = 1),
                    "retakeUnitAssigmnent" == t)
                  ) {
                    let t = b.courseitems[X];
                    t.meta.hasOwnProperty("assignments") &&
                      t.meta.assignments.length &&
                      (t.meta.assignments[e.assignmentIndex].status = 0);
                  }
                  let a = 0;
                  s.meta.assignments.map((e, t) => {
                    e.status && a++;
                  });
                  let i = (a / s.meta.assignments.length) * 100;
                  i >= 100
                    ? xe()
                    : 1 == s.status && (n.courseitems[X].status = 0),
                    (i = Math.round(i)),
                    me(i),
                    k(n);
                }
              }
              if (("mediaended" == t && xe(), "videosended" == t)) {
                let t = { ...b };
                if (
                  t.courseitems[X] &&
                  t.courseitems[X].hasOwnProperty("meta") &&
                  t.courseitems[X].meta.hasOwnProperty("video") &&
                  t.courseitems[X].meta.video.length
                ) {
                  t.courseitems[X].meta.hasOwnProperty("completion") ||
                    (t.courseitems[X].meta.completion = []),
                    t.courseitems[X].meta.completion[e.index] ||
                      (t.courseitems[X].meta.completion[e.index] = {
                        url: t.courseitems[X].meta.completion[e.index],
                        status: 0,
                      }),
                    (t.courseitems[X].meta.completion[e.index].status = 1);
                  let n = 0;
                  t.courseitems[X].meta.completion.map((e, t) => {
                    e && e.status && n++;
                  });
                  let s = Math.round(
                    (n / t.courseitems[X].meta.video.length) * 100
                  );
                  t.courseitems[X].hasOwnProperty("progressbar") ||
                    (t.courseitems[X].progressbar = 0),
                    s >= 100
                      ? ((s = 100), xe())
                      : ((t.courseitems[X].progressbar = s), k(t));
                }
              }
            },
            Ee = () => {
              if (
                window.wplms_course_data.hide_complete_course &&
                b &&
                b.hasOwnProperty("courseitems") &&
                b.courseitems &&
                b.courseitems.length
              )
                for (var e = 0; e < b.courseitems.length; e++)
                  if (
                    b.courseitems[e].hasOwnProperty("type") &&
                    "section" != b.courseitems[e].type &&
                    (!b.courseitems[e].hasOwnProperty("status") ||
                      !b.courseitems[e].status)
                  )
                    return !1;
              return !0;
            },
            Pe = (e, t = null) =>
              "undefined" != typeof localforage &&
              window.vibebp.api.sw_enabled &&
              navigator.onLine
                ? t
                  ? localforage.removeItem(e)
                  : localforage.iterate(function (t, n, s) {
                      e.length &&
                        n.length &&
                        n.includes(e) &&
                        localforage.removeItem(n);
                    })
                : new Promise((e) => {
                    e(1);
                  });
          return Ui(
            Yi,
            null,
            t
              ? Ui(d, null)
              : b
              ? Ui(
                  v.Provider,
                  {
                    value: {
                      courseStatus: b,
                      current_unit_key: X,
                      update: (e, t) => {
                        switch (t) {
                          case "loadunit":
                            e.hasOwnProperty("index") && _e(e.index);
                            break;
                          case "updateprogress":
                            e.hasOwnProperty("progress") && me(e.progress);
                            break;
                          case "progresscompleted":
                            xe();
                            break;
                          case "directmarkcomplete":
                            e.hasOwnProperty("index") &&
                              (b.hasOwnProperty("assignment_locking") &&
                              b.assignment_locking &&
                              b.courseitems[X].meta.hasOwnProperty(
                                "assignments"
                              ) &&
                              b.courseitems[X].meta.assignments.length
                                ? Qi("vibebp").addNotification({
                                    icon: "vicon-bookmark-alt",
                                    text: window.wplms_course_data.translations
                                      .complete_unit_assignments,
                                  })
                                : xe(e.index));
                        }
                      },
                    },
                  },
                  Ui(
                    "div",
                    {
                      className:
                        "course_status course_id_" +
                        e.course_id +
                        " " +
                        (O ? "moveonside" : ""),
                    },
                    A &&
                      b.hasOwnProperty("instructions") &&
                      b.instructions.length
                      ? Ui(
                          "div",
                          {
                            className: "course_instructions_wrapper",
                            onClick: (e) => {
                              document.querySelector(
                                ".course_instructions_wrapper"
                              ) &&
                                e.target ===
                                  document.querySelector(
                                    ".course_instructions_wrapper"
                                  ) &&
                                (e.preventDefault(), D(!1));
                            },
                          },
                          Ui(
                            "div",
                            { className: "course_instructions" },
                            Ui(
                              "div",
                              {
                                className: "close",
                                onClick: () => {
                                  D(!1);
                                },
                              },
                              Ui("span", { className: "vicon vicon-close" })
                            ),
                            Ui(
                              "h1",
                              null,
                              window.wplms_course_data.translations
                                .course_instructions
                            ),
                            Ui("div", {
                              dangerouslySetInnerHTML: {
                                __html: b.instructions,
                              },
                            })
                          )
                        )
                      : "",
                    j
                      ? Ui(
                          "div",
                          { className: "reviewpopup_wrapper" },
                          Ui(
                            "div",
                            { className: "reviewpopup_content" },
                            Ui(
                              "div",
                              { className: "finish-course-content" },
                              j.hasOwnProperty("percentage")
                                ? Ui(
                                    "span",
                                    {
                                      className: "finished_percentage",
                                      ref: qe,
                                    },
                                    Ui(
                                      "span",
                                      null,
                                      Ui(
                                        "span",
                                        null,
                                        Ui("strong", null, j.percentage),
                                        Ui("span", null, "%")
                                      ),
                                      Ui("span", null, j.title)
                                    )
                                  )
                                : "",
                              j.awards
                                ? Ui(
                                    "div",
                                    { className: "awards" },
                                    Object.keys(j.awards).map((e) =>
                                      "badge" == e
                                        ? Ui(
                                            "div",
                                            { className: "badge" },
                                            Ui("img", { src: j.awards[e].url }),
                                            Ui("span", null, j.awards[e].title)
                                          )
                                        : "certificate" == e
                                        ? Ui(
                                            "div",
                                            { className: "certificate" },
                                            Ui(
                                              "a",
                                              {
                                                href: j.awards[e].url,
                                                target: "_blank",
                                              },
                                              Ui(
                                                "svg",
                                                {
                                                  xmlns:
                                                    "http://www.w3.org/2000/svg",
                                                  width: "160",
                                                  height: "160",
                                                  viewBox: "0 0 24 24",
                                                },
                                                Ui("path", {
                                                  d: "M14.969 9.547l.031.191c0 .193-.096.379-.264.496-.538.372-.467.278-.67.885-.084.253-.33.424-.605.424h-.002c-.664-.002-.549-.038-1.083.338-.112.08-.244.119-.376.119s-.264-.039-.376-.118c-.534-.376-.419-.34-1.083-.338h-.002c-.275 0-.521-.171-.605-.424-.203-.607-.133-.513-.669-.885-.169-.118-.265-.304-.265-.497l.031-.19c.207-.604.208-.488 0-1.094l-.031-.191c0-.193.096-.379.265-.497.536-.372.465-.277.669-.885.084-.253.33-.424.605-.424h.002c.662.002.544.041 1.083-.338.112-.08.244-.119.376-.119s.264.039.376.118c.534.376.419.34 1.083.338h.002c.275 0 .521.171.605.424.203.607.132.513.67.885.168.118.264.304.264.497l-.031.191c-.207.604-.208.488 0 1.094zm-1.469-1.198l-.465-.464-1.41 1.446-.66-.627-.465.464 1.125 1.091 1.875-1.91zm4.5 4.651h-12v1h12v-1zm-1 2h-10v1h10v-1zm1 2h-12v1h12v-1zm1-15h-19v20h24v-20h-5zm3 15.422c-1.151.504-2.074 1.427-2.578 2.578h-14.844c-.504-1.151-1.427-2.074-2.578-2.578v-10.844c1.151-.504 2.074-1.427 2.578-2.578h14.844c.504 1.151 1.427 2.074 2.578 2.578v10.844z",
                                                })
                                              ),
                                              Ui(
                                                "span",
                                                null,
                                                window.wplms_course_data
                                                  .translations
                                                  .achievement_certificate
                                              )
                                            )
                                          )
                                        : "points" == e
                                        ? Ui(
                                            "div",
                                            { className: "points" },
                                            Ui(
                                              "svg",
                                              {
                                                xmlns:
                                                  "http://www.w3.org/2000/svg",
                                                width: "24",
                                                height: "24",
                                                viewBox: "0 0 24 24",
                                              },
                                              Ui("path", {
                                                d: "M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 3c-4.971 0-9 4.029-9 9s4.029 9 9 9 9-4.029 9-9-4.029-9-9-9zm1 13.947v1.053h-1v-.998c-1.035-.018-2.106-.265-3-.727l.455-1.644c.956.371 2.229.765 3.225.54 1.149-.26 1.385-1.442.114-2.011-.931-.434-3.778-.805-3.778-3.243 0-1.363 1.039-2.583 2.984-2.85v-1.067h1v1.018c.725.019 1.535.145 2.442.42l-.362 1.648c-.768-.27-1.616-.515-2.442-.465-1.489.087-1.62 1.376-.581 1.916 1.711.804 3.943 1.401 3.943 3.546.002 1.718-1.344 2.632-3 2.864z",
                                              })
                                            ),
                                            Ui("span", null, j.awards[e].amount)
                                          )
                                        : void 0
                                    )
                                  )
                                : "",
                              Ui(
                                "div",
                                { className: "post_completion_message" },
                                Ui("div", {
                                  className: "completion_message",
                                  dangerouslySetInnerHTML: {
                                    __html: j.message,
                                  },
                                }),
                                Ui("div", {
                                  dangerouslySetInnerHTML: {
                                    __html: j.post_message,
                                  },
                                })
                              ),
                              Ui(
                                "div",
                                { className: "popup-footer" },
                                Ui(
                                  "a",
                                  { className: "link", onClick: () => H(!1) },
                                  window.wplms_course_data.translations.cancel
                                ),
                                Ui(
                                  "a",
                                  {
                                    className: "button is-primary",
                                    onClick: e.back,
                                  },
                                  window.wplms_course_data.translations
                                    .back_to_my_courses,
                                  Ui("span", {
                                    className: "vicon vicon-arrow-right",
                                  })
                                )
                              )
                            )
                          )
                        )
                      : "",
                    C
                      ? Ui(
                          "div",
                          {
                            className: "reviewpopup_wrapper",
                            onClick: (e) => {
                              e.preventDefault(),
                                document.querySelector(
                                  ".reviewpopup_wrapper"
                                ) &&
                                  e.target ===
                                    document.querySelector(
                                      ".reviewpopup_wrapper"
                                    ) &&
                                  M(!1);
                            },
                          },
                          Ui(
                            "div",
                            { className: "reviewpopup_content" },
                            Ui(
                              "div",
                              {
                                className: "close",
                                onClick: () => {
                                  M(!1);
                                },
                              },
                              Ui("span", { className: "vicon vicon-close" })
                            ),
                            L
                              ? Ui(d, null)
                              : b.hasOwnProperty("comments_open") &&
                                b.comments_open
                              ? Ui(
                                  Yi,
                                  null,
                                  Ui(
                                    "div",
                                    { className: "reviewform" },
                                    Ui(
                                      "label",
                                      null,
                                      window.wplms_course_data.translations
                                        .rating
                                    ),
                                    Ui(Qa, {
                                      update: (e, t) => {
                                        if ("ratingchanged" == t) {
                                          let t = 0;
                                          e && (t = e.length);
                                          let n = { ...P };
                                          (n.rating = t), I(n);
                                        }
                                      },
                                      rating: P.rating,
                                    }),
                                    Ui("input", {
                                      type: "text",
                                      onChange: (e) => {
                                        let t = { ...P };
                                        (t.title = e.target.value), I(t);
                                      },
                                      value: P.title,
                                      placeholder:
                                        window.wplms_course_data.translations
                                          .review_title,
                                    }),
                                    Ui("textarea", {
                                      onChange: (e) => {
                                        let t = { ...P };
                                        (t.review = e.target.value), I(t);
                                      },
                                      value: P.review,
                                      placeholder:
                                        window.wplms_course_data.translations
                                          .your_review,
                                    })
                                  ),
                                  Ui(
                                    "div",
                                    { className: "popup-footer" },
                                    B
                                      ? Ui(
                                          Yi,
                                          null,
                                          Ui(
                                            "a",
                                            {
                                              href: "#",
                                              onClick: () => {
                                                ze(!0);
                                              },
                                            },
                                            Ui("span", {
                                              className:
                                                "vicon vicon-angle-left",
                                            }),
                                            " ",
                                            window.wplms_course_data
                                              .translations
                                              .skip_review_and_finish_course
                                          ),
                                          Ui(
                                            "a",
                                            {
                                              href: "#",
                                              className: L
                                                ? "button is-primary is-loading"
                                                : "button is-primary",
                                              onClick: () => {
                                                ze();
                                              },
                                            },
                                            window.wplms_course_data
                                              .translations
                                              .submit_review_and_finish_course,
                                            " ",
                                            Ui("span", {
                                              className:
                                                "vicon vicon-arrow-right",
                                            })
                                          )
                                        )
                                      : Ui(
                                          Yi,
                                          null,
                                          Ui(
                                            "a",
                                            {
                                              className: "link",
                                              onClick: () => M(!1),
                                            },
                                            window.wplms_course_data
                                              .translations.cancel
                                          ),
                                          Ui(
                                            "a",
                                            {
                                              className: "button is-primary",
                                              onClick: () => {
                                                P &&
                                                P.hasOwnProperty("title") &&
                                                P.hasOwnProperty("review") &&
                                                P.hasOwnProperty("rating") &&
                                                P.title.length > 3 &&
                                                P.review.length > 3 &&
                                                P.rating >= 1
                                                  ? (T(!0),
                                                    (P.comment_post_ID =
                                                      e.course_id),
                                                    (P.course_id = e.course_id),
                                                    (P.token = se.token),
                                                    fetch(
                                                      `${window.wplms_course_data.api_url}/updatecourse/addreview?post`,
                                                      {
                                                        method: "post",
                                                        headers: window.vibebp
                                                          .xnonce
                                                          ? {
                                                              "X-WP-Nonce":
                                                                window.vibebp
                                                                  .xnonce,
                                                            }
                                                          : {},
                                                        body: JSON.stringify(P),
                                                      }
                                                    )
                                                      .then((e) =>
                                                        e.ok
                                                          ? e.json()
                                                          : {
                                                              status: 0,
                                                              message:
                                                                window
                                                                  .wplms_course_data
                                                                  .translations
                                                                  .error_loading_data,
                                                            }
                                                      )
                                                      .then((t) => {
                                                        t
                                                          ? t.status
                                                            ? (T(!1),
                                                              t.hasOwnProperty(
                                                                "comment_id"
                                                              ) &&
                                                                t.comment_id &&
                                                                "undefined" !=
                                                                  typeof localforage &&
                                                                window.vibebp
                                                                  .api
                                                                  .sw_enabled &&
                                                                localforage
                                                                  .getItem(
                                                                    `${window.wplms_course_data.api_url}/user/getreview/${e.course_id}`
                                                                  )
                                                                  .then((n) => {
                                                                    n &&
                                                                      n.length &&
                                                                      "object" ==
                                                                        typeof (n =
                                                                          JSON.parse(
                                                                            n
                                                                          )) &&
                                                                      ((n.comment_ID =
                                                                        t.comment_id),
                                                                      (n.rating =
                                                                        P.rating),
                                                                      (n.review =
                                                                        P.review),
                                                                      (n.title =
                                                                        P.title),
                                                                      localforage.setItem(
                                                                        `${window.wplms_course_data.api_url}/user/getreview/${e.course_id}`,
                                                                        JSON.stringify(
                                                                          n
                                                                        )
                                                                      ));
                                                                  }))
                                                            : t.message &&
                                                              (alert(t.message),
                                                              T(!1))
                                                          : (alert(
                                                              window
                                                                .wplms_course_data
                                                                .translations
                                                                .error_review_form
                                                            ),
                                                            T(!1)),
                                                          M(!1);
                                                      })
                                                      .catch((e) => {
                                                        T(!1),
                                                          console.error(
                                                            "Uh oh, an error!",
                                                            e
                                                          ),
                                                          Qi(
                                                            "vibebp"
                                                          ).addNotification({
                                                            text: window
                                                              .wplms_course_data
                                                              .translations
                                                              .error_loading_data,
                                                          });
                                                      }))
                                                  : (alert(
                                                      window.wplms_course_data
                                                        .translations
                                                        .please_check_review_form
                                                    ),
                                                    T(!1));
                                              },
                                            },
                                            window.wplms_course_data
                                              .translations.submit_review,
                                            " ",
                                            Ui("span", {
                                              className:
                                                "vicon vicon-arrow-right",
                                            })
                                          )
                                        )
                                  )
                                )
                              : ""
                          )
                        )
                      : "",
                    (() => {
                      let e = 0;
                      if (
                        (b &&
                          b.courseitems &&
                          b.courseitems.length &&
                          b.courseitems[X] &&
                          "unit" == b.courseitems[X].type &&
                          !b.courseitems[X].status &&
                          b.courseitems[X].hasOwnProperty("meta") &&
                          b.courseitems[X].meta.hasOwnProperty("access") &&
                          b.courseitems[X].meta.access &&
                          ((e = 1),
                          b.hasOwnProperty("assignment_locking") &&
                            b.assignment_locking &&
                            b.courseitems[X].meta.hasOwnProperty(
                              "assignments"
                            ) &&
                            b.courseitems[X].meta.assignments.length &&
                            (e = 0),
                          b.courseitems[X].meta.hasOwnProperty("video") &&
                            (b.courseitems[X].meta.video.hasOwnProperty(
                              "url"
                            ) ||
                              (Array.isArray(b.courseitems[X].meta.video) &&
                                b.courseitems[X].meta.video.length)) &&
                            (e = 0),
                          b.courseitems[X].meta.hasOwnProperty("audio") &&
                            b.courseitems[X].meta.audio.hasOwnProperty("url") &&
                            (e = 0),
                          b.courseitems[X].meta.hasOwnProperty(
                            "disableprogress"
                          ) &&
                            b.courseitems[X].meta.disableprogress &&
                            (e = 0)),
                        b &&
                          b.hasOwnProperty("disablescrollprogress") &&
                          b.disablescrollprogress &&
                          (e = 0),
                        e)
                      )
                        return Ui(Ba, null);
                    })(),
                    b.package
                      ? u
                        ? Ui(d, null)
                        : Ui(
                            "div",
                            { className: "course_package_wrapper" },
                            Ui(
                              "div",
                              { className: "course_package_header" },
                              Ui("div", {
                                className: "vicon vicon-arrow-left",
                                onClick: () => {
                                  e.back(m);
                                },
                              }),
                              m || t
                                ? ""
                                : Ui(
                                    "div",
                                    {
                                      className:
                                        "finish_course button is-primary small",
                                      onClick: () => {
                                        Ne();
                                      },
                                    },
                                    window.wplms_course_data.translations
                                      .complete
                                  )
                            ),
                            Ui(
                              "div",
                              { className: "course_package" },
                              Ui("div", {
                                dangerouslySetInnerHTML: { __html: b.package },
                              })
                            )
                          )
                      : Ui(
                          Yi,
                          null,
                          Ui(
                            "div",
                            {
                              className: N
                                ? "course_timeline expand " +
                                  (i ? "comments_shown" : "")
                                : "course_timeline " +
                                  (i ? "comments_shown" : ""),
                            },
                            Ui(
                              "div",
                              { className: "course_action_points" },
                              Ui(
                                "div",
                                { className: "action_points" },
                                Ui("a", {
                                  className: "vicon vicon-arrow-left",
                                  onClick: e.back,
                                  title:
                                    window.wplms_course_data.translations.back,
                                }),
                                !s &&
                                  !sa(b) &&
                                  b.hasOwnProperty("courseitems") &&
                                  b.courseitems.length
                                  ? Ui(
                                      Yi,
                                      null,
                                      Ui("a", {
                                        className: "vicon vicon-search",
                                        onClick: () => {
                                          g(!0);
                                        },
                                        title:
                                          window.wplms_course_data.translations
                                            .search_unit,
                                      }),
                                      b.courseitems[X].hasOwnProperty("meta") &&
                                        b.courseitems[X].meta.hasOwnProperty(
                                          "access"
                                        ) &&
                                        b.courseitems[X].meta.access
                                        ? Ui(
                                            Yi,
                                            null,
                                            Ui("a", {
                                              className: "vicon vicon-comments",
                                              onClick: () => {
                                                r(!i);
                                              },
                                              title:
                                                window.wplms_course_data
                                                  .translations.comments,
                                            })
                                          )
                                        : ""
                                    )
                                  : "",
                                document
                                  .querySelector("body")
                                  .classList.contains("single-course")
                                  ? ""
                                  : Ui("a", {
                                      title: document
                                        .querySelector("body")
                                        .classList.contains(
                                          "course_status_fullscreen"
                                        )
                                        ? window.wplms_course_data.translations
                                            .minimise_screen
                                        : window.wplms_course_data.translations
                                            .maximise_screen,
                                      className: "vicon vicon-fullscreen",
                                      onClick: () => {
                                        document
                                          .querySelector("body")
                                          .classList.contains(
                                            "course_status_fullscreen"
                                          )
                                          ? document
                                              .querySelector("body")
                                              .classList.remove(
                                                "course_status_fullscreen"
                                              )
                                          : document
                                              .querySelector("body")
                                              .classList.add(
                                                "course_status_fullscreen"
                                              );
                                        var t = new CustomEvent(
                                          "course_status_fullscreen_toggle",
                                          {
                                            detail: {
                                              coursestatus: b,
                                              course_id: e.course_id,
                                            },
                                          }
                                        );
                                        document.dispatchEvent(t);
                                      },
                                    })
                              ),
                              w
                                ? Ui(
                                    "div",
                                    {
                                      className:
                                        "search-course " + (w ? "active" : ""),
                                    },
                                    Ui("input", {
                                      type: "text",
                                      placeholder:
                                        window.wplms_course_data.translations
                                          .search_course_elements,
                                      onChange: (e) => {
                                        h(e.target.value);
                                      },
                                      value: _,
                                    }),
                                    Ui(
                                      "span",
                                      null,
                                      b.filtered_items && _.length > 3
                                        ? b.filtered_items.length +
                                            " " +
                                            window.wplms_course_data
                                              .translations.results_found
                                        : ""
                                    ),
                                    Ui("span", {
                                      onClick: () => {
                                        g(!1), h("");
                                      },
                                      className: "vicon vicon-close",
                                    })
                                  )
                                : ""
                            ),
                            b &&
                              b.courseitems &&
                              b.courseitems[X] &&
                              "unit" == b.courseitems[X].type &&
                              i
                              ? Ui(Ma, {
                                  unit_id: b.courseitems[X].id,
                                  course_id: e.course_id,
                                  back: () => {
                                    r(!1);
                                  },
                                  expand: () => z(!N),
                                })
                              : "",
                            e.hasOwnProperty("course")
                              ? Ui(
                                  "div",
                                  { className: "course_heading", ref: l },
                                  Ui("h2", {
                                    dangerouslySetInnerHTML: { __html: f.name },
                                  }),
                                  Ui(
                                    "div",
                                    { class: "course_progress_wrapper" },
                                    Ui(
                                      "div",
                                      { className: "course_progress" },
                                      Ui("span", {
                                        style: { width: f.user_progress + "%" },
                                      })
                                    ),
                                    Ui("span", null, f.user_progress, "%")
                                  )
                                )
                              : "",
                            u ? Ui(d, null) : Ui(S, { courseHeadingRef: l })
                          ),
                          Ui(
                            "div",
                            { className: "course_content", ref: o },
                            Ui(
                              "div",
                              { className: "course_content_header" },
                              Ui(
                                "span",
                                {
                                  className: "toggle_timeline_wrapper",
                                  onClick: () => {
                                    E(!O);
                                  },
                                },
                                Ui("span", {
                                  className: O
                                    ? window.innerWidth < 480
                                      ? "vicon vicon-angle-double-down"
                                      : "vicon vicon-angle-double-right"
                                    : window.innerWidth < 480
                                    ? "vicon vicon-angle-double-up"
                                    : "vicon vicon-angle-double-left",
                                }),
                                Ui(
                                  "span",
                                  null,
                                  O
                                    ? window.wplms_course_data.translations
                                        .show_panel
                                    : window.wplms_course_data.translations
                                        .hide_panel
                                ),
                                Ui("span", {
                                  dangerouslySetInnerHTML: {
                                    __html:
                                      window.wplms_course_data.translations
                                        .drag_to_refresh,
                                  },
                                })
                              ),
                              Ui(
                                "div",
                                { className: "right_block" },
                                b.hasOwnProperty("comments_open")
                                  ? Ui(
                                      "span",
                                      {
                                        className: "review_block",
                                        onClick: () => (
                                          M(!0),
                                          void (
                                            P.hasOwnProperty("comment_ID") ||
                                            fetch(
                                              `${window.wplms_course_data.api_url}/user/getreview/${e.course_id}`,
                                              {
                                                method: "post",
                                                headers: window.vibebp.xnonce
                                                  ? {
                                                      "X-WP-Nonce":
                                                        window.vibebp.xnonce,
                                                    }
                                                  : {},
                                                body: JSON.stringify({
                                                  token: se.token,
                                                  course_id: e.course_id,
                                                }),
                                              }
                                            )
                                              .then((e) =>
                                                e.ok
                                                  ? e.json()
                                                  : {
                                                      status: 0,
                                                      message:
                                                        window.wplms_course_data
                                                          .translations
                                                          .error_loading_data,
                                                    }
                                              )
                                              .then((e) => {
                                                e && e.comment_ID && I(e),
                                                  T(!1);
                                              })
                                              .catch((e) => {
                                                T(!1),
                                                  console.error(
                                                    "Uh oh, an error!",
                                                    e
                                                  ),
                                                  Qi("vibebp").addNotification({
                                                    text: window
                                                      .wplms_course_data
                                                      .translations
                                                      .error_loading_data,
                                                  });
                                              })
                                          )
                                        ),
                                      },
                                      Ui("span", {
                                        className: "vicon vicon-star",
                                      }),
                                      Ui(
                                        "span",
                                        null,
                                        window.wplms_course_data.translations
                                          .leave_rating
                                      )
                                    )
                                  : "",
                                b && b.courseitems && b.courseitems.length
                                  ? Ui(
                                      "div",
                                      { className: "unit_prevnext" },
                                      Ui(
                                        "div",
                                        {
                                          className: "unit_prev navigate_unit",
                                          onClick: () => {
                                            ve("prev");
                                          },
                                        },
                                        q.prev
                                          ? Ui(
                                              Yi,
                                              null,
                                              Ui("span", {
                                                className:
                                                  "vicon vicon-arrow-left",
                                              }),
                                              Ui(
                                                "span",
                                                null,
                                                window.wplms_course_data
                                                  .translations.previous_unit
                                              )
                                            )
                                          : ""
                                      ),
                                      Ui(
                                        "div",
                                        {
                                          className: "unit_next navigate_unit",
                                          onClick: () => {
                                            ve("next");
                                          },
                                        },
                                        q.next
                                          ? Ui(
                                              Yi,
                                              null,
                                              Ui(
                                                "span",
                                                null,
                                                window.wplms_course_data
                                                  .translations.next_unit
                                              ),
                                              Ui("span", {
                                                className:
                                                  "vicon vicon-arrow-right",
                                              })
                                            )
                                          : ""
                                      )
                                    )
                                  : ""
                              )
                            ),
                            s || u
                              ? Ui(d, null)
                              : b && b.courseitems && b.courseitems.length
                              ? (() => {
                                  let t = 0,
                                    n = 0;
                                  b.courseitems.map((e, s) => {
                                    e.id && t++, s <= X && e.id && n++;
                                  });
                                  let s = "next_curriculum_item unlocked";
                                  switch (
                                    (b.hasOwnProperty("lock") &&
                                      b.lock &&
                                      !b.courseitems[X].status &&
                                      (s = "next_curriculum_item locked"),
                                    b.courseitems[X].type)
                                  ) {
                                    case "quiz":
                                      return Ui(
                                        "div",
                                        {
                                          className:
                                            "course_content_content_wrapper",
                                        },
                                        Ui(
                                          "div",
                                          {
                                            className: "course_content_content",
                                          },
                                          Ui(
                                            "span",
                                            { className: "lesson_info" },
                                            Ui(
                                              "span",
                                              null,
                                              window.wplms_course_data.reports
                                                .module.quiz,
                                              " ",
                                              n + "/" + t
                                            ),
                                            Ui(G, {
                                              timestamp:
                                                b.courseitems[X].duration,
                                              notimediff: 1,
                                            })
                                          ),
                                          Ui("h2", {
                                            dangerouslySetInnerHTML: {
                                              __html: b.courseitems[X].title,
                                            },
                                          }),
                                          b.courseitems[X].hasOwnProperty(
                                            "quiz_type"
                                          )
                                            ? Ui(
                                                "div",
                                                null,
                                                (() => {
                                                  var t = {
                                                    coursestatus: b,
                                                    type: b.courseitems[X]
                                                      .quiz_type,
                                                    id: b.courseitems[X].id,
                                                    course_id: e.course_id,
                                                  };
                                                  b.courseitems[
                                                    X
                                                  ].hasOwnProperty(
                                                    "content_id"
                                                  ) &&
                                                    (t.content_id =
                                                      b.courseitems[
                                                        X
                                                      ].content_id);
                                                  var n = new CustomEvent(
                                                    "custom_quiz_type",
                                                    { detail: t }
                                                  );
                                                  return (
                                                    document.dispatchEvent(n),
                                                    Ui("div", {
                                                      id: b.courseitems[X]
                                                        .quiz_type,
                                                      quizid:
                                                        b.courseitems[X].id,
                                                    })
                                                  );
                                                })()
                                              )
                                            : Ui(Os, {
                                                quizid: b.courseitems[X].id,
                                                update: be,
                                                course: e.course_id,
                                              })
                                        ),
                                        X + 1 < b.courseitems.length
                                          ? Ui(
                                              "div",
                                              {
                                                className: s,
                                                onClick: () => {
                                                  ve("next");
                                                },
                                              },
                                              b.courseitems[X + 1].icon
                                                ? b.courseitems[X + 1].icon
                                                    .length > 200
                                                  ? Ui(
                                                      "span",
                                                      null,
                                                      Ui("span", {
                                                        dangerouslySetInnerHTML:
                                                          {
                                                            __html:
                                                              b.courseitems[
                                                                X + 1
                                                              ].icon,
                                                          },
                                                      }),
                                                      Ui("span", {
                                                        dangerouslySetInnerHTML:
                                                          {
                                                            __html:
                                                              b.courseitems[
                                                                X + 1
                                                              ].title,
                                                          },
                                                      })
                                                    )
                                                  : Ui(
                                                      "span",
                                                      null,
                                                      Ui("span", {
                                                        className:
                                                          b.courseitems[X + 1]
                                                            .icon,
                                                      }),
                                                      Ui("span", {
                                                        dangerouslySetInnerHTML:
                                                          {
                                                            __html:
                                                              b.courseitems[
                                                                X + 1
                                                              ].title,
                                                          },
                                                      })
                                                    )
                                                : Ui("span", {
                                                    dangerouslySetInnerHTML: {
                                                      __html:
                                                        b.courseitems[X + 1]
                                                          .title,
                                                    },
                                                  })
                                            )
                                          : b.hasOwnProperty("course_status") &&
                                            parseInt(b.course_status) < 3 &&
                                            Ee()
                                          ? Ui(
                                              "div",
                                              { className: "finish_course" },
                                              Ui(
                                                "a",
                                                {
                                                  className:
                                                    "button is-primary is-fullwidth",
                                                  onClick: () => {
                                                    Ne();
                                                  },
                                                },
                                                Ui("span", {
                                                  className:
                                                    "vicon vicon-check-box",
                                                  style: { margin: "0 1rem" },
                                                }),
                                                window.wplms_course_data
                                                  .translations.complete_course
                                              )
                                            )
                                          : ""
                                      );
                                    case "wplms-assignment":
                                      return Ui(
                                        "div",
                                        {
                                          className:
                                            "course_content_content_wrapper",
                                        },
                                        Ui(
                                          "div",
                                          {
                                            className: "course_content_content",
                                          },
                                          Ui(
                                            "span",
                                            { className: "lesson_info" },
                                            Ui(
                                              "span",
                                              null,
                                              window.wplms_course_data.reports
                                                .module.assignment,
                                              " ",
                                              n + "/" + t
                                            ),
                                            Ui(G, {
                                              timestamp:
                                                b.courseitems[X].duration,
                                              notimediff: 1,
                                            })
                                          ),
                                          Ui("h2", {
                                            dangerouslySetInnerHTML: {
                                              __html: b.courseitems[X].title,
                                            },
                                          }),
                                          Ui(ma, {
                                            assignment: b.courseitems[X].meta,
                                            update: ke,
                                            course: e.course_id,
                                          })
                                        ),
                                        X + 1 < b.courseitems.length
                                          ? Ui(
                                              "div",
                                              {
                                                className: s,
                                                onClick: () => {
                                                  ve("next");
                                                },
                                              },
                                              Ui(
                                                "span",
                                                null,
                                                Ui("span", {
                                                  className: b.courseitems[
                                                    X + 1
                                                  ].icon
                                                    ? b.courseitems[X + 1].icon
                                                    : "",
                                                }),
                                                Ui("span", {
                                                  dangerouslySetInnerHTML: {
                                                    __html:
                                                      b.courseitems[X + 1]
                                                        .title,
                                                  },
                                                })
                                              )
                                            )
                                          : b.hasOwnProperty("course_status") &&
                                            parseInt(b.course_status) < 3 &&
                                            Ee()
                                          ? Ui(
                                              "div",
                                              { className: "finish_course" },
                                              Ui(
                                                "a",
                                                {
                                                  className:
                                                    "button is-primary is-fullwidth",
                                                  onClick: () => {
                                                    Ne();
                                                  },
                                                },
                                                Ui("span", {
                                                  className:
                                                    "vicon vicon-check-box",
                                                  style: { margin: "0 1rem" },
                                                }),
                                                window.wplms_course_data
                                                  .translations.complete_course
                                              )
                                            )
                                          : ""
                                      );
                                    default:
                                      return Ui(
                                        "div",
                                        {
                                          className:
                                            "course_content_content_wrapper",
                                        },
                                        b.courseitems[X].hasOwnProperty(
                                          "custom_unit_type"
                                        )
                                          ? Ui(
                                              "div",
                                              null,
                                              (() => {
                                                var t = {
                                                  coursestatus: b,
                                                  type: b.courseitems[X]
                                                    .custom_unit_type,
                                                  id: b.courseitems[X].id,
                                                  course_id: e.course_id,
                                                };
                                                b.courseitems[X].hasOwnProperty(
                                                  "content_id"
                                                ) &&
                                                  (t.content_id =
                                                    b.courseitems[
                                                      X
                                                    ].content_id);
                                                var n = new CustomEvent(
                                                  "custom_unit_type",
                                                  { detail: t }
                                                );
                                                return (
                                                  document.dispatchEvent(n),
                                                  Ui("div", {
                                                    id: b.courseitems[X]
                                                      .unit_type,
                                                    quizid: b.courseitems[X].id,
                                                  })
                                                );
                                              })()
                                            )
                                          : Ui(Ci, {
                                              curriculumItem: b.courseitems[X],
                                              update: Se,
                                              index: X,
                                              item_number: n,
                                              total_item_count: t,
                                              coursestatus: b,
                                              course: e.course_id,
                                            }),
                                        X + 1 < b.courseitems.length
                                          ? Ui(
                                              "div",
                                              {
                                                className: s,
                                                onClick: () => {
                                                  ve("next");
                                                  let e = 0;
                                                  b &&
                                                    b.courseitems &&
                                                    b.courseitems.length &&
                                                    b.courseitems[X] &&
                                                    "unit" ==
                                                      b.courseitems[X].type &&
                                                    !b.courseitems[X].status &&
                                                    b.courseitems[
                                                      X
                                                    ].hasOwnProperty("meta") &&
                                                    b.courseitems[
                                                      X
                                                    ].meta.hasOwnProperty(
                                                      "access"
                                                    ) &&
                                                    b.courseitems[X].meta
                                                      .access &&
                                                    ((e = 1),
                                                    b.hasOwnProperty(
                                                      "assignment_locking"
                                                    ) &&
                                                      b.assignment_locking &&
                                                      b.courseitems[
                                                        X
                                                      ].meta.hasOwnProperty(
                                                        "assignments"
                                                      ) &&
                                                      b.courseitems[X].meta
                                                        .assignments.length &&
                                                      (e = 0),
                                                    b.unit_media_lock &&
                                                      ((b.courseitems[
                                                        X
                                                      ].meta.hasOwnProperty(
                                                        "video"
                                                      ) &&
                                                        Array.isArray(
                                                          b.courseitems[X].meta
                                                            .video
                                                        ) &&
                                                        b.courseitems[X].meta
                                                          .video.length) ||
                                                        "video" ==
                                                          b.courseitems[X]
                                                            .unit_type) &&
                                                      (e = 0),
                                                    "unit" !==
                                                      b.courseitems[X].type &&
                                                      (e = 0),
                                                    b.courseitems[X] &&
                                                      b.courseitems[
                                                        X
                                                      ].hasOwnProperty(
                                                        "meta"
                                                      ) &&
                                                      b.courseitems[
                                                        X
                                                      ].meta.hasOwnProperty(
                                                        "disableprogress"
                                                      ) &&
                                                      b.courseitems[X].meta
                                                        .disableprogress &&
                                                      (e = 0)),
                                                    e && xe(X);
                                                },
                                              },
                                              b.courseitems[X + 1].icon
                                                ? b.courseitems[X + 1].icon
                                                    .length > 200
                                                  ? Ui(
                                                      "span",
                                                      null,
                                                      Ui("span", {
                                                        dangerouslySetInnerHTML:
                                                          {
                                                            __html:
                                                              b.courseitems[
                                                                X + 1
                                                              ].icon,
                                                          },
                                                      }),
                                                      Ui("span", {
                                                        dangerouslySetInnerHTML:
                                                          {
                                                            __html:
                                                              b.courseitems[
                                                                X + 1
                                                              ].title,
                                                          },
                                                      })
                                                    )
                                                  : Ui(
                                                      "span",
                                                      null,
                                                      Ui("span", {
                                                        className:
                                                          b.courseitems[X + 1]
                                                            .icon,
                                                      }),
                                                      Ui("span", {
                                                        dangerouslySetInnerHTML:
                                                          {
                                                            __html:
                                                              b.courseitems[
                                                                X + 1
                                                              ].title,
                                                          },
                                                      })
                                                    )
                                                : Ui("span", {
                                                    dangerouslySetInnerHTML: {
                                                      __html:
                                                        b.courseitems[X + 1]
                                                          .title,
                                                    },
                                                  })
                                            )
                                          : b.hasOwnProperty("course_status") &&
                                            parseInt(b.course_status) < 3 &&
                                            Ee()
                                          ? Ui(
                                              "div",
                                              { className: "finish_course" },
                                              Ui(
                                                "a",
                                                {
                                                  className:
                                                    "button is-primary is-fullwidth",
                                                  onClick: () => {
                                                    Ne();
                                                  },
                                                },
                                                Ui("span", {
                                                  className:
                                                    "vicon vicon-check-box",
                                                  style: { margin: "0 1rem" },
                                                }),
                                                window.wplms_course_data
                                                  .translations.complete_course
                                              )
                                            )
                                          : ""
                                      );
                                  }
                                })()
                              : "",
                            te
                              ? Ui("span", {
                                  className:
                                    "vibebp_content_show_fireworks finished_percentage",
                                  ref: qe,
                                })
                              : ""
                          )
                        )
                  )
                )
              : ""
          );
        },
        {
          createElement: Zi,
          render: er,
          useState: tr,
          useEffect: nr,
          Fragment: sr,
        } = wp.element,
        { select: ar, dispatch: ir } = wp.data,
        rr = (e) => {
          ar("vibebp").getUser();
          const t = ar("vibebp").getToken(),
            [n, s] = tr(!0),
            [a, i] = tr(window.wplms_course_data.translations.take_this_course),
            [r, o] = tr(""),
            [l, u] = tr({}),
            [c, d] = tr(-1),
            [m, p] = tr(""),
            [_, h] = tr([]),
            [w, g] = tr(!1),
            [f, v] = tr(!1),
            [y, b] = tr({}),
            [k, q] = tr(!1),
            [x, N] = tr(!1),
            [z, O] = tr(!1),
            [S, E] = tr(!1);
          nr(() => {
            document.addEventListener(
              "wplms_popup_applied",
              (t) => {
                t.detail.course == e.id &&
                  t.detail.hasOwnProperty("text") &&
                  (v(!1), o("#"), i(t.detail.text));
              },
              !1
            ),
              document.addEventListener(
                "reload_course_button",
                (t) => {
                  t.detail.course == e.id && P(!0);
                },
                !1
              );
          }),
            nr(() => {
              P();
            }, [e]),
            nr(() => {
              if (z) {
                var t = new CustomEvent("wplms_popup_clicked", {
                  detail: { course: e.id },
                });
                document.dispatchEvent(t), O(!1);
              }
            }, [z]);
          const P = (n = null) => {
              if (
                (s(!0),
                q(!1),
                !n && e.hasOwnProperty("coursedata") && e.coursedata)
              ) {
                let t = e.coursedata;
                t.status &&
                  (t.text.length &&
                    ("#apply" == t.link && v(!0),
                    i(t.text),
                    t.hasOwnProperty("error")
                      ? b(t.error)
                      : (o(t.link),
                        u(t.course),
                        d(t.course_status),
                        t.hasOwnProperty("form") && p(t.form)),
                    h(t.extras)),
                  t.hasOwnProperty("hide_button") && t.hide_button && q(!0),
                  t.hasOwnProperty("is_free") && t.is_free && E(!0)),
                  s(!1);
              } else
                fetch(
                  `${window.wplms_course_data.api_url}/student/courseButton/?course=${e.id}&force`,
                  {
                    method: "post",
                    body: JSON.stringify({
                      id: e.id,
                      token: t,
                      price: window.wplms_course_data.show_price,
                    }),
                  }
                )
                  .then((e) => e.json())
                  .then((e) => {
                    e.status &&
                      (e.text.length &&
                        ("#apply" == e.link && v(!0),
                        i(e.text),
                        e.hasOwnProperty("error")
                          ? b(e.error)
                          : (o(e.link),
                            u(e.course),
                            d(e.course_status),
                            e.hasOwnProperty("form") && p(e.form)),
                        h(e.extras)),
                      e.hasOwnProperty("hide_button") && e.hide_button && q(!0),
                      e.hasOwnProperty("is_free") && e.is_free && E(!0)),
                      s(!1);
                  });
            },
            I = (t, n) => {
              var s = new CustomEvent("coursebuttonpricingclicked", {
                detail: { original_event: t, course: e.id, price: n },
              });
              document.dispatchEvent(s);
            };
          return k
            ? ""
            : w
            ? Zi(
                sr,
                null,
                Zi(
                  "div",
                  { class: "lds-ellipsis" },
                  Zi("div", null),
                  Zi("div", null),
                  Zi("div", null),
                  Zi("div", null)
                ),
                ReactDOM.createPortal(
                  Zi(Gi, {
                    course_id: l.id,
                    course: l,
                    back: () => {
                      g(!1);
                    },
                    index: 1,
                    update: () => {},
                  }),
                  document.querySelector("#wplms_the_course_button")
                )
              )
            : n
            ? Zi(
                "span",
                { className: "course_button button full is-loading" },
                "..."
              )
            : Zi(
                sr,
                null,
                f
                  ? Zi(
                      "span",
                      { className: "the_course_button" },
                      Zi(
                        "a",
                        {
                          href: r,
                          className: "course_button button full",
                          onClick: (e) => {
                            e.preventDefault(), O(!0);
                          },
                        },
                        Zi("span", { dangerouslySetInnerHTML: { __html: a } }),
                        _.length
                          ? Zi(
                              "div",
                              { className: "extra_details" },
                              _.map((e) => Zi("span", null, e))
                            )
                          : ""
                      )
                    )
                  : m.length
                  ? Zi(
                      "div",
                      { className: " the_course_button" },
                      Zi(
                        "form",
                        { action: m, className: "", method: "post" },
                        Zi("input", {
                          type: "hidden",
                          name: "token",
                          value: t,
                        }),
                        Zi("input", {
                          type: "hidden",
                          name: "course_id",
                          value: e.id,
                        }),
                        Zi(
                          "button",
                          {
                            type: "submit",
                            className: "button full course_button",
                          },
                          Zi("span", {
                            dangerouslySetInnerHTML: { __html: a },
                          }),
                          _.length ? _.map((e) => Zi("span", null, e)) : ""
                        )
                      )
                    )
                  : Zi(
                      sr,
                      null,
                      Zi(
                        "span",
                        { className: "the_course_button" },
                        r && r.length
                          ? c > -1
                            ? Zi(
                                "span",
                                null,
                                Zi(
                                  "a",
                                  {
                                    onClick: () => {
                                      g(!0);
                                    },
                                    className: "course_button button full",
                                  },
                                  a
                                )
                              )
                            : Array.isArray(r) && r.length
                            ? Zi(
                                "strong",
                                { className: "course_button button full" },
                                Zi(
                                  "a",
                                  {
                                    href: r[0].link,
                                    onClick: (e) => {
                                      I(e, r[0]);
                                    },
                                  },
                                  Zi(
                                    "strong",
                                    null,
                                    a && a.length
                                      ? a
                                      : window.wplms_course_data.translations
                                          .take_this_course
                                  ),
                                  Zi("span", {
                                    dangerouslySetInnerHTML: {
                                      __html: r[0].price,
                                    },
                                  })
                                ),
                                r.length > 1
                                  ? Zi(
                                      sr,
                                      null,
                                      Zi("input", {
                                        id: "course_price",
                                        type: "checkbox",
                                      }),
                                      Zi("label", {
                                        for: "course_price",
                                        class: "vicon vicon-angle-down",
                                      }),
                                      Zi(
                                        "div",
                                        { className: "wplms_price_dropdown" },
                                        r.map((e) =>
                                          Zi("a", {
                                            href: e.link,
                                            dangerouslySetInnerHTML: {
                                              __html: e.price,
                                            },
                                            onClick: (t) => {
                                              I(t, e);
                                            },
                                          })
                                        )
                                      )
                                    )
                                  : "",
                                _.length
                                  ? Zi(
                                      "div",
                                      { className: "extra_details" },
                                      _.map((e) =>
                                        Zi("span", {
                                          dangerouslySetInnerHTML: {
                                            __html: e,
                                          },
                                        })
                                      )
                                    )
                                  : ""
                              )
                            : Zi(
                                "a",
                                {
                                  href: r,
                                  className: "course_button button full",
                                  onClick: (e) => {
                                    I(e, r);
                                  },
                                },
                                a && a.length
                                  ? a
                                  : window.wplms_course_data.translations
                                      .take_this_course,
                                _.length
                                  ? Zi(
                                      "div",
                                      { className: "extra_details" },
                                      _.map((e) =>
                                        Zi("span", {
                                          dangerouslySetInnerHTML: {
                                            __html: e,
                                          },
                                        })
                                      )
                                    )
                                  : ""
                              )
                          : Zi(
                              "a",
                              c < 0 && S
                                ? {
                                    href: r,
                                    className: "course_button button full",
                                    onClick: (n) => {
                                      n.preventDefault(),
                                        s(!0),
                                        fetch(
                                          `${window.wplms_course_data.api_url}/user/subscribe?post`,
                                          {
                                            method: "post",
                                            body: JSON.stringify({
                                              course_id: e.id,
                                              token: t,
                                            }),
                                          }
                                        )
                                          .then((e) => e.json())
                                          .then((e) => {
                                            e.status && P(!0),
                                              e.hasOwnProperty("message") &&
                                                e.message &&
                                                e.message.length &&
                                                ir("vibebp").addNotification({
                                                  text: e.message,
                                                }),
                                              s(!1);
                                          });
                                    },
                                  }
                                : {
                                    href: r,
                                    className: "course_button button full",
                                    onClick: (e) => {
                                      I(e, r);
                                    },
                                  },
                              Zi(
                                "strong",
                                null,
                                a && a.length
                                  ? a
                                  : window.wplms_course_data.translations
                                      .take_this_course
                              ),
                              _.length
                                ? Zi(
                                    "div",
                                    { className: "extra_details" },
                                    _.map((e) => Zi("span", null, e))
                                  )
                                : ""
                            )
                      ),
                      y && y.hasOwnProperty("error_message")
                        ? Zi(
                            "div",
                            { className: "vbp_message error" },
                            Zi("span", {
                              className: "vicon " + y.icon,
                              style: { margin: "0 0.2rem" },
                            }),
                            Zi("span", {
                              dangerouslySetInnerHTML: {
                                __html: y.error_message,
                              },
                            })
                          )
                        : ""
                    )
              );
        },
        or = (e) => {
          let t = [];
          document.querySelectorAll(".the_course_button").forEach((e) => {
            e.classList.add("is-loading"), t.push(e.getAttribute("data-id"));
          }),
            fetch(
              `${
                window.wplms_course_data.api_url
              }/student/courseButtons/?courses=${JSON.stringify(t)}&force`,
              {
                method: "post",
                body: JSON.stringify({
                  ids: t,
                  token: ar("vibebp").getToken(),
                  price: window.wplms_course_data.show_price,
                }),
              }
            )
              .then((e) =>
                e.ok
                  ? e.json()
                  : {
                      status: 0,
                      message:
                        window.wplms_course_data.translations
                          .error_loading_data,
                    }
              )
              .then((e) => {
                e.status && Object.keys(e.courses).length
                  ? document
                      .querySelectorAll(".the_course_button")
                      .forEach((t) => {
                        t.classList.remove("is-loading");
                        let n = t.getAttribute("data-id");
                        e.courses.hasOwnProperty(n) &&
                          er(
                            Zi(rr, {
                              id: n,
                              def: t.innerHTML,
                              coursedata: e.courses[n],
                            }),
                            t
                          );
                      })
                  : (document
                      .querySelectorAll(".the_course_button")
                      .forEach((e) => {
                        e.classList.remove("is-loading");
                      }),
                    ir("vibebp").addNotification({
                      text: window.wplms_course_data.translations
                        .error_loading_data,
                    }));
              })
              .catch((e) => {
                setIsLoading(!1),
                  console.error("Uh oh, an error!", e),
                  ir("vibebp").addNotification({
                    text: window.wplms_course_data.translations
                      .error_loading_data,
                  });
              }),
            document.removeEventListener("userLoaded", or, !1);
        };
      document.addEventListener("userLoaded", or, !1),
        document.addEventListener(
          "wplms_popup_clicked",
          (e) => {
            null !== document.getElementById("wplms_popup") &&
              document.getElementById("wplms_popup").remove();
            let t = document.createElement("div");
            t.setAttribute("id", "wplms_popup"),
              document.body.appendChild(t),
              er(
                Zi(l, { id: e.detail.course }),
                document.getElementById("wplms_popup")
              );
          },
          !1
        );
    })();
})();
