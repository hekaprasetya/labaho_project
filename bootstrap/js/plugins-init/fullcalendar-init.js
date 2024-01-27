const xhttp = new XMLHttpRequest();
const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  },
});
function getData(o) {
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        try {
          const events = JSON.parse(this.responseText);
          o.$calendarObj.fullCalendar("renderEvents", events, true);
        } catch (error) {
          console.error("Error parsing JSON response:", error);
        }
      } else {
        console.error("HTTP request failed with status:", this.status);
      }
    }
  };

  xhttp.open("GET", "proses_calender.php?info=get", true);
  xhttp.send();
}
function delCalendar(t) {
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        Toast.fire({
          icon: "success",
          title: "Acara Berhasil Dihapus",
        });
      } else {
        console.error("HTTP request failed with status:", this.status);
        Swal.fire({
          icon: "error",
          title: "Gagal Menghapus Data",
          text: "Terjadi kesalahan!",
        }).then(() => {
          location.reload();
        });
      }
    }
  };
  xhttp.open("POST", "proses_calender.php?info=delete", true);
  xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
  xhttp.send(JSON.stringify({ id: t.id }));
}
function updateCalendar(t, ev) {
  var eventUpdate = {
    title: ev,
    id: t.id,
  };
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        // Tanggapi dari server (jika diperlukan)
        Toast.fire({
          icon: "success",
          title: "Acara Berhasil Diperbarui",
        });
      } else {
        Toast.fire({
          icon: "error",
          title: "Terjadi Kesalahan...",
        }).then(() => {
          location.reload();
        });
        // console.error("HTTP request failed with status:", this.status);
      }
    }
  };

  xhttp.open("GET", "proses_calender.php?info=update", true);
  xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
  xhttp.send(JSON.stringify(eventUpdate));
}
function addCalendar(data) {
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        try {
          const response = JSON.parse(this.responseText);
          if (response.success) {
            Toast.fire({
              icon: "success",
              title: "Acara Berhasil Disimpan",
            });
          } else {
            Toast.fire({
              icon: "error",
              title: "Terjadi Kesalahan...",
            });
          }
        } catch (error) {
          console.error("Error parsing JSON response:", error);
        }
      } else {
        console.error("HTTP request failed with status:", this.status);
      }
    }
  };

  xhttp.open("POST", "proses_calender.php?info=add", true);
  xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
  xhttp.send(JSON.stringify(data));
}
function addDropCalendar(data) {
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        try {
          const response = JSON.parse(this.responseText);
          if (response.success) {
            Toast.fire({
              icon: "success",
              title: "Acara Berhasil Disimpan",
            });
          } else {
            Toast.fire({
              icon: "error",
              title: "Terjadi Kesalahan...",
            });
          }
        } catch (error) {
          console.error("Error parsing JSON response:", error);
        }
      } else {
        console.error("HTTP request failed with status:", this.status);
      }
    }
  };

  xhttp.open("POST", "proses_calender.php?info=drop", true);
  xhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
  xhttp.send(JSON.stringify(data));
}
!(function (e) {
  "use strict";
  var t = function () {
    (this.$body = e("body")),
      (this.$modal = e("#event-modal")),
      (this.$event = "#external-events div.external-event"),
      (this.$calendar = e("#calendar")),
      (this.$saveCategoryBtn = e(".save-category")),
      (this.$categoryForm = e("#add-category form")),
      (this.$extEvents = e("#external-events")),
      (this.$calendarObj = null);
  };
  (t.prototype.onDrop = function (t, n) {
    var a = t.data("eventObject"),
      o = t.attr("data-class"),
      i = e.extend({}, a);
    (i.start = n),
      o && (i.className = [o]),
      this.$calendar.fullCalendar("renderEvent", i, !0),
      e("#drop-remove").is(":checked") && t.remove();
    addDropCalendar(i);
  }),
    (t.prototype.onEventClick = function (t, n, a) {
      var o = this,
        i = e("<form></form>");
      i.append("<label>Change event name</label>"),
        i.append(
          "<div class='input-group'><input class='form-control' type=text value='" +
            t.title +
            "' /><span class='input-group-btn'><button type='submit' class='btn btn-success waves-effect waves-light'><i class='fa fa-check'></i> Save</button></span></div>"
        ),
        o.$modal.modal({
          backdrop: "static",
        }),
        o.$modal
          .find(".delete-event")
          .show()
          .end()
          .find(".save-event")
          .hide()
          .end()
          .find(".modal-body")
          .empty()
          .prepend(i)
          .end()
          .find(".delete-event")
          .unbind("click")
          .on("click", function () {
            o.$calendarObj.fullCalendar("removeEvents", function (e) {
              return e._id == t._id;
            }),
              delCalendar(t);
            o.$modal.modal("hide");
          }),
        o.$modal.find("form").on("submit", function () {
          var ev = i.find("input[type=text]").val();
          updateCalendar(t, ev);
          return (
            (t.title = ev),
            o.$calendarObj.fullCalendar("updateEvent", t),
            o.$modal.modal("hide"),
            !1
          );
        });
    }),
    (t.prototype.onSelect = function (t, n, a) {
      var o = this;
      o.$modal.modal({
        backdrop: "static",
      });
      var i = e("<form></form>");
      i.append("<div class='row'></div>"),
        i
          .find(".row")
          .append(
            "<div class='col-md-6'><div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div></div>"
          )
          .append(
            "<div class='col-md-6'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>"
          )
          .find("select[name='category']")
          .append("<option value='bg-danger'>Danger</option>")
          .append("<option value='bg-success'>Success</option>")
          .append("<option value='bg-dark'>Dark</option>")
          .append("<option value='bg-primary'>Primary</option>")
          .append("<option value='bg-pink'>Pink</option>")
          .append("<option value='bg-info'>Info</option>")
          .append("<option value='bg-warning'>Warning</option></div></div>"),
        o.$modal
          .find(".delete-event")
          .hide()
          .end()
          .find(".save-event")
          .show()
          .end()
          .find(".modal-body")
          .empty()
          .prepend(i)
          .end()
          .find(".save-event")
          .unbind("click")
          .on("click", function () {
            i.submit();
          }),
        o.$modal.find("form").on("submit", function () {
          var e = i.find("input[name='title']").val(),
            a =
              (i.find("input[name='beginning']").val(),
              i.find("input[name='ending']").val(),
              i.find("select[name='category'] option:checked").val());
          var eventData = {
            title: e,
            start: t,
            end: n,
            allDay: !1,
            className: a,
          };
          addCalendar(eventData);
          return (
            null !== e && 0 != e.length
              ? (o.$calendarObj.fullCalendar(
                  "renderEvent",
                  {
                    title: e,
                    start: t,
                    end: n,
                    allDay: !1,
                    className: a,
                  },
                  !0
                ),
                o.$modal.modal("hide"))
              : Swal.fire({
                  icon: "warning",
                  title: "Judul Kosong",
                  text: "Anda harus memberikan judul pada acara Anda",
                }),
            !1
          );
        }),
        o.$calendarObj.fullCalendar("unselect");
    }),
    (t.prototype.enableDrag = function () {
      e(this.$event).each(function () {
        var t = {
          title: e.trim(e(this).text()),
        };
        e(this).data("eventObject", t),
          e(this).draggable({
            zIndex: 999,
            revert: !0,
            revertDuration: 0,
          });
      });
    }),
    (t.prototype.init = function () {
      this.enableDrag();
      var t = new Date(),
        n = (t.getDate(), t.getMonth(), t.getFullYear(), new Date(e.now())),
        a = [],
        o = this;
      getData(o);
      (o.$calendarObj = o.$calendar.fullCalendar({
        slotDuration: "00:15:00",
        minTime: "08:00:00",
        maxTime: "19:00:00",
        defaultView: "month",
        handleWindowResize: !0,
        height: e(window).height() - 200,
        header: {
          left: "prev,next today",
          center: "title",
          right: "month,agendaWeek,agendaDay",
        },
        events: a,
        editable: !0,
        droppable: !0,
        eventLimit: !0,
        selectable: !0,
        drop: function (t) {
          o.onDrop(e(this), t);
        },
        select: function (e, t, n) {
          o.onSelect(e, t, n);
        },
        eventClick: function (e, t, n) {
          o.onEventClick(e, t, n);
        },
      })),
        this.$saveCategoryBtn.on("click", function () {
          var e = o.$categoryForm.find("input[name='category-name']").val(),
            t = o.$categoryForm.find("select[name='category-color']").val();
          null !== e &&
            0 != e.length &&
            (o.$extEvents.append(
              '<div class="external-event bg-' +
                t +
                '" data-class="bg-' +
                t +
                '" style="position: relative;"><i class="fa fa-move"></i>' +
                e +
                "</div>"
            ),
            o.enableDrag());
        });
    }),
    (e.CalendarApp = new t()),
    (e.CalendarApp.Constructor = t);
})(window.jQuery),
  (function (e) {
    "use strict";
    e.CalendarApp.init();
  })(window.jQuery);
