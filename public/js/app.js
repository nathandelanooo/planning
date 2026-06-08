// resources/js/app.js

const API_BASE = "/api";

// Tambahan
const STORAGE_KEY = "planning_spa_db_v1";
const CURRENT_USER_ID = 1;

const todayISO = () => new Date().toISOString().slice(0, 10);
const isoFromOffset = (days = 0) => {
  const d = new Date();
  d.setDate(d.getDate() + days);
  return d.toISOString().slice(0, 10);
};

function loadDB() {
  const seed = {
    users: [{ id_pengguna: 1, username: "Wilson", password: "123", id_role: 2 }],
    roles: [
      { id_role: 1, nama_role: "Admin" },
      { id_role: 2, nama_role: "User" }
    ],
    categories: [
      { id_kategori: 1, jenis_kategori: "Workout", tipe_kategori: "habit" },
      { id_kategori: 2, jenis_kategori: "Reading", tipe_kategori: "habit" },
      { id_kategori: 3, jenis_kategori: "Meditation", tipe_kategori: "habit" },
      { id_kategori: 4, jenis_kategori: "Food", tipe_kategori: "expense" },
      { id_kategori: 5, jenis_kategori: "Transport", tipe_kategori: "expense" },
      { id_kategori: 6, jenis_kategori: "Academic", tipe_kategori: "expense" },
      { id_kategori: 7, jenis_kategori: "Daily", tipe_kategori: "expense" }
    ],
    todos: [
      {
        id_toDoList: 1,
        id_pengguna: 1,
        judul_list: "Kerjakan Laporan UTS",
        isi_list: "Selesaikan revisi bagian CRUD dan navigasi SPA.",
        tanggal_mulai: isoFromOffset(0),
        waktu_mulai: "08:00",
        tanggal_selesai: isoFromOffset(1),
        waktu_selesai: "20:00",
        status: "pending"
      }
    ],
    habits: [
      {
        id_habit_tracker: 1,
        id_pengguna: 1,
        id_kategori: 1,
        nama_habit: "Workout",
        hari: "Senin, Rabu, Jumat",
        reminder_time: "19:00",
        status: "active"
      }
    ],
    expenses: [
      {
        id_pengeluaran: 1,
        id_pengguna: 1,
        id_kategori: 4,
        tanggal: isoFromOffset(0),
        keterangan: "Makan siang",
        nominal: 25000
      }
    ],
    notes: [
      {
        id_notes: 1,
        id_pengguna: 1,
        judul_notes: "Ide Project Aplikasi",
        isi_notes: "Buat aplikasi planner dengan fitur lengkap.",
        file_audio: "",
        tanggal: isoFromOffset(0),
        waktu: "10:00"
      }
    ],
    reminders: [
      {
        id_reminder: 1,
        id_pengguna: 1,
        judul: "Meeting Kelompok",
        tanggal: isoFromOffset(0),
        waktu: "10:00",
        sumber: "todo",
        status: "active"
      }
    ]
  };

  const saved = localStorage.getItem(STORAGE_KEY);
  if (!saved) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(seed));
    return seed;
  }

  try {
    return { ...seed, ...JSON.parse(saved) };
  } catch {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(seed));
    return seed;
  }
}

let db = loadDB();
let activeTodoFilter = "all";
let activeHabitFilter = "all";
let currentMonth = new Date();
let selectedDateISO = todayISO();

const rupiah = (value) =>
  new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    maximumFractionDigits: 0
  }).format(Number(value || 0));

function saveDB() {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(db));
  renderAll();
}

function nextId(arr, key) {
  return arr.length ? Math.max(...arr.map(x => Number(x[key]) || 0)) + 1 : 1;
}

function isoToIDDate(iso) {
  if (!iso) return "-";
  const d = new Date(iso + "T00:00:00");
  return d.toLocaleDateString("id-ID", {
    day: "2-digit",
    month: "long",
    year: "numeric"
  });
}

function badgeClass(status) {
  if (status === "completed" || status === "done") return "badge-completed";
  if (status === "progress") return "badge-progress";
  return "badge-pending";
}

function statusLabel(status) {
  if (status === "completed") return "Completed";
  if (status === "progress") return "In Progress";
  if (status === "done") return "Done";
  if (status === "inactive") return "Inactive";
  if (status === "cancelled") return "Cancelled";
  return "Pending";
}

function formatUser() {
  const user = db.users.find(u => u.id_pengguna === CURRENT_USER_ID);
  const userName = document.getElementById("userName");
  // if (userName && user) userName.textContent = user.username;
}

function getCategories(type) {
  return db.categories.filter(c => c.tipe_kategori === type);
}

function fillCategorySelects() {
  const habitSel = document.getElementById("habit_id_kategori");
  const expenseSel = document.getElementById("expense_id_kategori");

  if (habitSel) {
    habitSel.innerHTML = getCategories("habit")
      .map(c => `<option value="${c.id_kategori}">${c.jenis_kategori}</option>`)
      .join("");
  }

  if (expenseSel) {
    expenseSel.innerHTML = getCategories("expense")
      .map(c => `<option value="${c.id_kategori}">${c.jenis_kategori}</option>`)
      .join("");
  }
}

function clearTodoForm() {
  const ids = ["todo_id_toDoList", "todo_judul_list", "todo_isi_list", "todo_tanggal_mulai", "todo_waktu_mulai", "todo_tanggal_selesai", "todo_waktu_selesai"];
  ids.forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;
    if (id.includes("tanggal")) el.value = todayISO();
    else if (id.includes("waktu")) el.value = "08:00";
    else el.value = "";
  });
  const status = document.getElementById("todo_status");
  if (status) status.value = "pending";
}

function clearHabitForm() {
  const map = {
    habit_id_habit_tracker: "",
    habit_nama_habit: "",
    habit_hari: "",
    habit_reminder_time: "19:00"
  };
  Object.entries(map).forEach(([id, value]) => {
    const el = document.getElementById(id);
    if (el) el.value = value;
  });
  const status = document.getElementById("habit_status");
  if (status) status.value = "active";
  const cat = document.getElementById("habit_id_kategori");
  if (cat) cat.selectedIndex = 0;
}

function clearExpenseForm() {
  const map = {
    expense_id_pengeluaran: "",
    expense_tanggal: todayISO(),
    expense_keterangan: "",
    expense_nominal: ""
  };
  Object.entries(map).forEach(([id, value]) => {
    const el = document.getElementById(id);
    if (el) el.value = value;
  });
  const cat = document.getElementById("expense_id_kategori");
  if (cat) cat.selectedIndex = 0;
}

function clearNotesForm() {
  const map = {
    notes_id_notes: "",
    notes_judul_notes: "",
    notes_isi_notes: "",
    notes_tanggal: todayISO(),
    notes_waktu: "10:00"
  };
  Object.entries(map).forEach(([id, value]) => {
    const el = document.getElementById(id);
    if (el) el.value = value;
  });
  const audio = document.getElementById("notes_file_audio");
  if (audio) audio.value = "";
}

function clearReminderForm() {
  const map = {
    reminder_id_reminder: "",
    reminder_judul: "",
    reminder_tanggal: todayISO(),
    reminder_waktu: "10:00"
  };
  Object.entries(map).forEach(([id, value]) => {
    const el = document.getElementById(id);
    if (el) el.value = value;
  });
  const sumber = document.getElementById("reminder_sumber");
  const status = document.getElementById("reminder_status");
  if (sumber) sumber.value = "todo";
  if (status) status.value = "active";
}

function renderDashboardSummary() {
  const statTasks = document.getElementById("statTasks");
  const statHabits = document.getElementById("statHabits");
  const statExpense = document.getElementById("statExpense");
  const statScore = document.getElementById("statScore");
  const notifCount = document.getElementById("notifCount");

  const completedTodos = db.todos.filter(t => t.status === "completed").length;
  const activeHabits = db.habits.filter(h => h.status === "active").length;
  const totalExpense = db.expenses.reduce((s, e) => s + Number(e.nominal || 0), 0);
  const tasksToday = db.todos.filter(t => t.tanggal_mulai === todayISO() || t.tanggal_selesai === todayISO()).length;
  const score = db.todos.length
    ? Math.round((completedTodos / db.todos.length) * 60 + (activeHabits / Math.max(db.habits.length, 1)) * 40)
    : 0;

  if (statTasks) statTasks.textContent = tasksToday;
  if (statHabits) statHabits.textContent = activeHabits;
  if (statExpense) statExpense.textContent = rupiah(totalExpense);
  if (statScore) statScore.textContent = `${score}%`;
  if (notifCount) notifCount.textContent = db.reminders.filter(r => r.status === "active").length;
}

function renderDashboardPreviews() {
  const todoPreview = document.getElementById("dashboardTodoPreview");
  const expensePreview = document.getElementById("dashboardExpensePreview");
  const notePreview = document.getElementById("dashboardNotePreview");

  if (todoPreview) {
    todoPreview.innerHTML = db.todos.slice(0, 3).map(t => `
      <div class="todo-item d-flex align-items-start gap-3">
        <div class="mini-icon"><i class="fa-regular fa-circle-check"></i></div>
        <div class="flex-grow-1">
          <div class="fw-semibold">${t.judul_list}</div>
          <div class="muted">${isoToIDDate(t.tanggal_mulai)} • ${t.waktu_mulai} <span class="mx-2">•</span> ${statusLabel(t.status)}</div>
        </div>
      </div>
    `).join("") || `<div class="empty-state">Belum ada data to-do.</div>`;
  }

  if (expensePreview) {
    expensePreview.innerHTML = db.expenses.slice(0, 3).map(e => {
      const cat = db.categories.find(c => c.id_kategori == e.id_kategori);
      return `
        <div class="expense-item d-flex align-items-center gap-3">
          <div class="mini-icon" style="background:#fff7e9;color:#f59e0b;"><i class="fa-solid fa-receipt"></i></div>
          <div class="flex-grow-1">
            <div class="fw-semibold">${e.keterangan}</div>
            <div class="muted">${isoToIDDate(e.tanggal)} • ${cat ? cat.jenis_kategori : "-"}</div>
          </div>
          <div class="fw-bold" style="color:#ef4444;">-${rupiah(e.nominal)}</div>
        </div>
      `;
    }).join("") || `<div class="empty-state">Belum ada catatan pengeluaran.</div>`;
  }

  if (notePreview) {
    notePreview.innerHTML = db.notes.slice(0, 3).map(n => `
      <div class="note-item d-flex align-items-center gap-3">
        <div class="mini-icon" style="background:#fff7e9;color:#f59e0b;"><i class="fa-solid fa-note-sticky"></i></div>
        <div class="flex-grow-1">
          <div class="fw-semibold">${n.judul_notes}</div>
          <div class="muted">${n.isi_notes.slice(0, 70)}${n.isi_notes.length > 70 ? "..." : ""}</div>
        </div>
      </div>
    `).join("") || `<div class="empty-state">Belum ada notes.</div>`;
  }
}

function renderTodos(filter = "all") {
  const tbody = document.getElementById("todoTable");
  if (!tbody) return;

  const list = db.todos.filter(t => filter === "all" ? true : t.status === filter);

  tbody.innerHTML = list.length ? list.map(t => `
    <tr>
      <td>
        <div class="fw-bold">${t.judul_list}</div>
        <div class="muted">${t.isi_list}</div>
      </td>
      <td>${isoToIDDate(t.tanggal_mulai)}<br><span class="muted">${t.waktu_mulai}</span></td>
      <td>${isoToIDDate(t.tanggal_selesai)}<br><span class="muted">${t.waktu_selesai}</span></td>
      <td><span class="badge-soft ${badgeClass(t.status)}">${statusLabel(t.status)}</span></td>
      <td class="text-end">
        <button class="action-btn edit" data-edit-todo="${t.id_toDoList}"><i class="fa-solid fa-pen"></i></button>
        <button class="action-btn delete" data-del-todo="${t.id_toDoList}"><i class="fa-solid fa-trash"></i></button>
      </td>
    </tr>
  `).join("") : `<tr><td colspan="5"><div class="empty-state">Belum ada data to-do.</div></td></tr>`;

  document.querySelectorAll("[data-edit-todo]").forEach(btn => {
    btn.onclick = () => editTodo(btn.dataset.editTodo);
  });
  document.querySelectorAll("[data-del-todo]").forEach(btn => {
    btn.onclick = () => deleteTodo(btn.dataset.delTodo);
  });
}

function renderHabits(filter = "all") {
  const tbody = document.getElementById("habitTable");
  if (!tbody) return;

  const list = db.habits.filter(h => filter === "all" ? true : h.status === filter);

  tbody.innerHTML = list.length ? list.map(h => {
    const cat = db.categories.find(c => c.id_kategori == h.id_kategori);
    return `
      <tr>
        <td>
          <div class="fw-bold">${h.nama_habit}</div>
        </td>
        <td>${cat ? cat.jenis_kategori : "-"}</td>
        <td>${h.hari}</td>
        <td>${h.reminder_time}</td>
        <td><span class="badge-soft ${badgeClass(h.status)}">${statusLabel(h.status)}</span></td>
        <td class="text-end">
          <button class="action-btn edit" data-edit-habit="${h.id_habit_tracker}"><i class="fa-solid fa-pen"></i></button>
          <button class="action-btn delete" data-del-habit="${h.id_habit_tracker}"><i class="fa-solid fa-trash"></i></button>
        </td>
      </tr>
    `;
  }).join("") : `<tr><td colspan="6"><div class="empty-state">Belum ada data habit.</div></td></tr>`;

  document.querySelectorAll("[data-edit-habit]").forEach(btn => {
    btn.onclick = () => editHabit(btn.dataset.editHabit);
  });
  document.querySelectorAll("[data-del-habit]").forEach(btn => {
    btn.onclick = () => deleteHabit(btn.dataset.delHabit);
  });
}

function renderExpenses() {
  const tbody = document.getElementById("expenseTable");
  const totalEl = document.getElementById("expenseTotalPage");
  const countEl = document.getElementById("expenseCountPage");

  if (!tbody) return;

  const total = db.expenses.reduce((sum, item) => sum + Number(item.nominal || 0), 0);
  if (totalEl) totalEl.textContent = rupiah(total);
  if (countEl) countEl.textContent = db.expenses.length;

  tbody.innerHTML = db.expenses.length ? db.expenses.map(e => {
    const cat = db.categories.find(c => c.id_kategori == e.id_kategori);
    return `
      <tr>
        <td>${isoToIDDate(e.tanggal)}</td>
        <td>${cat ? cat.jenis_kategori : "-"}</td>
        <td>
          <div class="fw-bold">${e.keterangan}</div>
        </td>
        <td>${rupiah(e.nominal)}</td>
        <td class="text-end">
          <button class="action-btn edit" data-edit-expense="${e.id_pengeluaran}"><i class="fa-solid fa-pen"></i></button>
          <button class="action-btn delete" data-del-expense="${e.id_pengeluaran}"><i class="fa-solid fa-trash"></i></button>
        </td>
      </tr>
    `;
  }).join("") : `<tr><td colspan="5"><div class="empty-state">Belum ada catatan pengeluaran.</div></td></tr>`;

  document.querySelectorAll("[data-edit-expense]").forEach(btn => {
    btn.onclick = () => editExpense(btn.dataset.editExpense);
  });
  document.querySelectorAll("[data-del-expense]").forEach(btn => {
    btn.onclick = () => deleteExpense(btn.dataset.delExpense);
  });
}

function renderNotes() {
  const container = document.getElementById("notesListPage");
  const countEl = document.getElementById("notesCountPage");
  if (!container) return;

  if (countEl) countEl.textContent = db.notes.length;

  container.innerHTML = db.notes.length ? db.notes.map(n => `
    <div class="note-card">
      <div class="d-flex justify-content-between align-items-start gap-3">
        <div>
          <div class="fw-bold">${n.judul_notes}</div>
          <div class="muted mb-2">${isoToIDDate(n.tanggal)} • ${n.waktu}</div>
        </div>
        <div>
          <button class="action-btn edit" data-edit-notes="${n.id_notes}"><i class="fa-solid fa-pen"></i></button>
          <button class="action-btn delete" data-del-notes="${n.id_notes}"><i class="fa-solid fa-trash"></i></button>
        </div>
      </div>

      <div class="note-preview mb-2">${n.isi_notes}</div>

      ${n.file_audio ? `<span class="audio-chip"><i class="fa-solid fa-volume-high"></i> Voice Notes</span>` : ""}
    </div>
  `).join("") : `<div class="empty-state">Belum ada notes.</div>`;

  document.querySelectorAll("[data-edit-notes]").forEach(btn => {
    btn.onclick = () => editNotes(btn.dataset.editNotes);
  });
  document.querySelectorAll("[data-del-notes]").forEach(btn => {
    btn.onclick = () => deleteNotes(btn.dataset.delNotes);
  });
}

function renderReminders() {
  const container = document.getElementById("reminderListPage");
  const countEl = document.getElementById("reminderCountPage");
  if (!container) return;

  if (countEl) countEl.textContent = db.reminders.length;

  container.innerHTML = db.reminders.length ? db.reminders.map(r => `
    <div class="reminder-item d-flex align-items-center gap-3">
      <div class="mini-icon" style="background:#f3efff;color:var(--primary);">
        <i class="fa-solid fa-bell"></i>
      </div>
      <div class="flex-grow-1">
        <div class="fw-semibold">${r.judul}</div>
        <div class="muted">${isoToIDDate(r.tanggal)} • ${r.waktu} • ${r.sumber}</div>
      </div>
      <span class="badge-soft ${badgeClass(r.status)}">${statusLabel(r.status)}</span>
      <div>
        <button class="action-btn edit" data-edit-reminder="${r.id_reminder}"><i class="fa-solid fa-pen"></i></button>
        <button class="action-btn delete" data-del-reminder="${r.id_reminder}"><i class="fa-solid fa-trash"></i></button>
      </div>
    </div>
  `).join("") : `<div class="empty-state">Belum ada reminder.</div>`;

  document.querySelectorAll("[data-edit-reminder]").forEach(btn => {
    btn.onclick = () => editReminder(btn.dataset.editReminder);
  });
  document.querySelectorAll("[data-del-reminder]").forEach(btn => {
    btn.onclick = () => deleteReminder(btn.dataset.delReminder);
  });
}

function getEventsForDate(dateISO) {
  const todoEvents = db.todos
    .filter(t => t.tanggal_mulai === dateISO || t.tanggal_selesai === dateISO)
    .map(t => ({ title: t.judul_list, time: t.waktu_mulai, type: "To-Do", status: t.status }));

  const reminderEvents = db.reminders
    .filter(r => r.tanggal === dateISO)
    .map(r => ({ title: r.judul, time: r.waktu, type: "Reminder", status: r.status }));

  return [...todoEvents, ...reminderEvents].sort((a, b) => a.time.localeCompare(b.time));
}

function renderCalendar() {
  const monthEl = document.getElementById("calendarMonth");
  const gridEl = document.getElementById("calGrid");
  const headEl = document.getElementById("calHead");
  const agendaEl = document.getElementById("selectedDayAgenda");
  const eventListEl = document.getElementById("calendarEventList");
  const selectedDateLabel = document.getElementById("selectedDateLabel");
  const agendaCount = document.getElementById("agendaCount");
  const monthEventCount = document.getElementById("monthEventCount");

  if (!monthEl || !gridEl || !headEl) return;

  const year = currentMonth.getFullYear();
  const month = currentMonth.getMonth();

  monthEl.textContent = currentMonth.toLocaleDateString("id-ID", {
    month: "long",
    year: "numeric"
  });

  const weekDays = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];
  headEl.innerHTML = weekDays.map(d => `<div class="cal-day-head">${d}</div>`).join("");

  const firstDay = new Date(year, month, 1).getDay();
  const lastDate = new Date(year, month + 1, 0).getDate();
  const today = new Date();

  let cells = [];
  for (let i = 0; i < firstDay; i++) cells.push('<div class="cal-day empty">.</div>');

  for (let d = 1; d <= lastDate; d++) {
    const dateISO = new Date(year, month, d).toISOString().slice(0, 10);
    const events = getEventsForDate(dateISO);
    const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === d;
    const isSelected = selectedDateISO === dateISO;

    cells.push(`
      <div class="cal-day ${isToday ? "today" : ""} ${isSelected ? "active-day" : ""} ${events.length ? "has-event" : ""}" data-cal-day="${dateISO}">
        ${d}
      </div>
    `);
  }

  while (cells.length % 7 !== 0) cells.push('<div class="cal-day empty">.</div>');
  gridEl.innerHTML = cells.join("");

  document.querySelectorAll("[data-cal-day]").forEach(day => {
    day.onclick = () => {
      selectedDateISO = day.dataset.calDay;
      renderCalendar();
    };
  });

  const events = getEventsForDate(selectedDateISO);
  if (selectedDateLabel) selectedDateLabel.textContent = isoToIDDate(selectedDateISO);
  if (agendaCount) agendaCount.textContent = `${events.length} agenda`;

  agendaEl.innerHTML = events.length ? events.map(ev => `
    <div class="d-flex align-items-center gap-3 mb-2">
      <div class="badge-soft ${badgeClass(ev.status)}" style="min-width:72px;justify-content:center;">
        ${ev.time || "--:--"}
      </div>
      <div>
        <div class="fw-semibold">${ev.title}</div>
        <div class="muted">${ev.type}</div>
      </div>
    </div>
  `).join("") : `<div class="empty-state">Tidak ada agenda pada tanggal ini.</div>`;

  const monthEvents = [
    ...db.todos.map(t => ({ date: t.tanggal_mulai, title: t.judul_list, time: t.waktu_mulai, type: "To-Do" })),
    ...db.reminders.map(r => ({ date: r.tanggal, title: r.judul, time: r.waktu, type: "Reminder" }))
  ].filter(ev => ev.date && ev.date.slice(0, 7) === selectedDateISO.slice(0, 7));

  if (monthEventCount) monthEventCount.textContent = monthEvents.length;

  if (eventListEl) {
    eventListEl.innerHTML = monthEvents.length ? monthEvents.map(ev => `
      <div class="summary-mini mb-2">
        <div class="fw-semibold">${ev.title}</div>
        <div class="muted">${isoToIDDate(ev.date)} • ${ev.time} • ${ev.type}</div>
      </div>
    `).join("") : `<div class="empty-state">Belum ada event pada bulan ini.</div>`;
  }
}

function renderAll() {
  formatUser();
  fillCategorySelects();
  renderDashboardSummary();
  renderDashboardPreviews();
  renderTodos(activeTodoFilter);
  renderHabits(activeHabitFilter);
  renderExpenses();
  renderNotes();
  renderReminders();
  if (document.getElementById("calendarMonth")) renderCalendar();
}

function editTodo(id) {
  const t = db.todos.find(x => x.id_toDoList == id);
  if (!t) return;
  document.getElementById("todo_id_toDoList").value = t.id_toDoList;
  document.getElementById("todo_judul_list").value = t.judul_list;
  document.getElementById("todo_isi_list").value = t.isi_list;
  document.getElementById("todo_tanggal_mulai").value = t.tanggal_mulai;
  document.getElementById("todo_waktu_mulai").value = t.waktu_mulai;
  document.getElementById("todo_tanggal_selesai").value = t.tanggal_selesai;
  document.getElementById("todo_waktu_selesai").value = t.waktu_selesai;
  document.getElementById("todo_status").value = t.status;
  window.scrollTo({ top: 0, behavior: "smooth" });
}

function deleteTodo(id) {
  if (!confirm("Hapus to-do ini?")) return;
  db.todos = db.todos.filter(x => x.id_toDoList != id);
  saveDB();
}

function editHabit(id) {
  const h = db.habits.find(x => x.id_habit_tracker == id);
  if (!h) return;
  document.getElementById("habit_id_habit_tracker").value = h.id_habit_tracker;
  document.getElementById("habit_id_kategori").value = h.id_kategori;
  document.getElementById("habit_nama_habit").value = h.nama_habit;
  document.getElementById("habit_hari").value = h.hari;
  document.getElementById("habit_reminder_time").value = h.reminder_time;
  document.getElementById("habit_status").value = h.status;
  window.scrollTo({ top: 0, behavior: "smooth" });
}

function deleteHabit(id) {
  if (!confirm("Hapus habit ini?")) return;
  db.habits = db.habits.filter(x => x.id_habit_tracker != id);
  saveDB();
}

function editExpense(id) {
  const ex = db.expenses.find(x => x.id_pengeluaran == id);
  if (!ex) return;
  document.getElementById("expense_id_pengeluaran").value = ex.id_pengeluaran;
  document.getElementById("expense_id_kategori").value = ex.id_kategori;
  document.getElementById("expense_tanggal").value = ex.tanggal;
  document.getElementById("expense_keterangan").value = ex.keterangan;
  document.getElementById("expense_nominal").value = ex.nominal;
  window.scrollTo({ top: 0, behavior: "smooth" });
}

function deleteExpense(id) {
  if (!confirm("Hapus pengeluaran ini?")) return;
  db.expenses = db.expenses.filter(x => x.id_pengeluaran != id);
  saveDB();
}

function editNotes(id) {
  const n = db.notes.find(x => x.id_notes == id);
  if (!n) return;
  document.getElementById("notes_id_notes").value = n.id_notes;
  document.getElementById("notes_judul_notes").value = n.judul_notes;
  document.getElementById("notes_isi_notes").value = n.isi_notes;
  document.getElementById("notes_tanggal").value = n.tanggal;
  document.getElementById("notes_waktu").value = n.waktu;
  const audio = document.getElementById("notes_file_audio");
  if (audio) audio.value = "";
  window.scrollTo({ top: 0, behavior: "smooth" });
}

function deleteNotes(id) {
  if (!confirm("Hapus notes ini?")) return;
  db.notes = db.notes.filter(x => x.id_notes != id);
  saveDB();
}

function editReminder(id) {
  const r = db.reminders.find(x => x.id_reminder == id);
  if (!r) return;
  document.getElementById("reminder_id_reminder").value = r.id_reminder;
  document.getElementById("reminder_judul").value = r.judul;
  document.getElementById("reminder_tanggal").value = r.tanggal;
  document.getElementById("reminder_waktu").value = r.waktu;
  document.getElementById("reminder_sumber").value = r.sumber;
  document.getElementById("reminder_status").value = r.status;
  window.scrollTo({ top: 0, behavior: "smooth" });
}

function deleteReminder(id) {
  if (!confirm("Hapus reminder ini?")) return;
  db.reminders = db.reminders.filter(x => x.id_reminder != id);
  saveDB();
}

function initForms() {
  const todoForm = document.getElementById("todoForm");
  if (todoForm) {
    todoForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const id = document.getElementById("todo_id_toDoList").value;
      const payload = {
        id_toDoList: id ? Number(id) : nextId(db.todos, "id_toDoList"),
        id_pengguna: CURRENT_USER_ID,
        judul_list: document.getElementById("todo_judul_list").value.trim(),
        isi_list: document.getElementById("todo_isi_list").value.trim(),
        tanggal_mulai: document.getElementById("todo_tanggal_mulai").value,
        waktu_mulai: document.getElementById("todo_waktu_mulai").value,
        tanggal_selesai: document.getElementById("todo_tanggal_selesai").value,
        waktu_selesai: document.getElementById("todo_waktu_selesai").value,
        status: document.getElementById("todo_status").value
      };

      if (id) db.todos = db.todos.map(x => x.id_toDoList == id ? payload : x);
      else db.todos.unshift(payload);

      clearTodoForm();
      saveDB();
    });
  }

  const habitForm = document.getElementById("habitForm");
  if (habitForm) {
    habitForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const id = document.getElementById("habit_id_habit_tracker").value;
      const payload = {
        id_habit_tracker: id ? Number(id) : nextId(db.habits, "id_habit_tracker"),
        id_pengguna: CURRENT_USER_ID,
        id_kategori: Number(document.getElementById("habit_id_kategori").value),
        nama_habit: document.getElementById("habit_nama_habit").value.trim(),
        hari: document.getElementById("habit_hari").value.trim(),
        reminder_time: document.getElementById("habit_reminder_time").value,
        status: document.getElementById("habit_status").value
      };

      if (id) db.habits = db.habits.map(x => x.id_habit_tracker == id ? payload : x);
      else db.habits.unshift(payload);

      clearHabitForm();
      saveDB();
    });
  }

  const expenseForm = document.getElementById("expenseForm");
  if (expenseForm) {
    expenseForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const id = document.getElementById("expense_id_pengeluaran").value;
      const payload = {
        id_pengeluaran: id ? Number(id) : nextId(db.expenses, "id_pengeluaran"),
        id_pengguna: CURRENT_USER_ID,
        id_kategori: Number(document.getElementById("expense_id_kategori").value),
        tanggal: document.getElementById("expense_tanggal").value,
        keterangan: document.getElementById("expense_keterangan").value.trim(),
        nominal: Number(document.getElementById("expense_nominal").value || 0)
      };

      if (id) db.expenses = db.expenses.map(x => x.id_pengeluaran == id ? payload : x);
      else db.expenses.unshift(payload);

      clearExpenseForm();
      saveDB();
    });
  }

  const notesForm = document.getElementById("notesForm");
  if (notesForm) {
    notesForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const id = document.getElementById("notes_id_notes").value;
      const fileInput = document.getElementById("notes_file_audio");
      const fileName = fileInput && fileInput.files[0] ? fileInput.files[0].name : "";

      const payload = {
        id_notes: id ? Number(id) : nextId(db.notes, "id_notes"),
        id_pengguna: CURRENT_USER_ID,
        judul_notes: document.getElementById("notes_judul_notes").value.trim(),
        isi_notes: document.getElementById("notes_isi_notes").value.trim(),
        file_audio: fileName,
        tanggal: document.getElementById("notes_tanggal").value,
        waktu: document.getElementById("notes_waktu").value
      };

      if (id) db.notes = db.notes.map(x => x.id_notes == id ? payload : x);
      else db.notes.unshift(payload);

      clearNotesForm();
      saveDB();
    });
  }

  const reminderForm = document.getElementById("reminderForm");
  if (reminderForm) {
    reminderForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const id = document.getElementById("reminder_id_reminder").value;
      const payload = {
        id_reminder: id ? Number(id) : nextId(db.reminders, "id_reminder"),
        id_pengguna: CURRENT_USER_ID,
        judul: document.getElementById("reminder_judul").value.trim(),
        tanggal: document.getElementById("reminder_tanggal").value,
        waktu: document.getElementById("reminder_waktu").value,
        sumber: document.getElementById("reminder_sumber").value,
        status: document.getElementById("reminder_status").value
      };

      if (id) db.reminders = db.reminders.map(x => x.id_reminder == id ? payload : x);
      else db.reminders.unshift(payload);

      clearReminderForm();
      saveDB();
    });
  }

  const todoResetBtn = document.getElementById("todoResetBtn");
  if (todoResetBtn) todoResetBtn.onclick = clearTodoForm;

  const habitResetBtn = document.getElementById("habitResetBtn");
  if (habitResetBtn) habitResetBtn.onclick = clearHabitForm;

  const expenseResetBtn = document.getElementById("expenseResetBtn");
  if (expenseResetBtn) expenseResetBtn.onclick = clearExpenseForm;

  const notesResetBtn = document.getElementById("notesResetBtn");
  if (notesResetBtn) notesResetBtn.onclick = clearNotesForm;

  const reminderResetBtn = document.getElementById("reminderResetBtn");
  if (reminderResetBtn) reminderResetBtn.onclick = clearReminderForm;

  document.querySelectorAll("[data-todo-filter]").forEach(btn => {
    btn.onclick = () => {
      activeTodoFilter = btn.dataset.todoFilter;
      renderTodos(activeTodoFilter);
    };
  });

  document.querySelectorAll("[data-habit-filter]").forEach(btn => {
    btn.onclick = () => {
      activeHabitFilter = btn.dataset.habitFilter;
      renderHabits(activeHabitFilter);
    };
  });

  const prevMonth = document.getElementById("prevMonth");
  const nextMonth = document.getElementById("nextMonth");
  if (prevMonth) {
    prevMonth.onclick = () => {
      currentMonth = new Date(currentMonth.getFullYear(), currentMonth.getMonth() - 1, 1);
      renderCalendar();
    };
  }
  if (nextMonth) {
    nextMonth.onclick = () => {
      currentMonth = new Date(currentMonth.getFullYear(), currentMonth.getMonth() + 1, 1);
      renderCalendar();
    };
  }
}

function bootstrapApp() {
  fillCategorySelects();
  initForms();
  renderAll();
}

document.addEventListener("DOMContentLoaded", bootstrapApp);