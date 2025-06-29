const addBtn = document.getElementById("addBtn");
const taskNameInput = document.getElementById("taskName");
const taskPrioritySelect = document.getElementById("taskPriority");
const board = document.getElementById("board");
const trashList = document.getElementById("trashList");
const emptyTrashBtn = document.getElementById("emptyTrashBtn");
const filterInput = document.getElementById("filterInput");
const filterBy = document.getElementById("filterBy");
const toggleDarkBtn = document.getElementById("toggleDarkBtn");

let tasks = [];
let trash = [];

function getPriorityClasses(priority) {
  switch (priority) {
    case "HIGH":
      return "bg-red-100 border-red-500 text-red-800 dark:bg-red-900 dark:border-red-700 dark:text-red-400";
    case "MEDIUM":
      return "bg-yellow-100 border-yellow-500 text-yellow-800 dark:bg-yellow-900 dark:border-yellow-700 dark:text-yellow-400";
    case "LOW":
    default:
      return "bg-green-100 border-green-500 text-green-800 dark:bg-green-900 dark:border-green-700 dark:text-green-400";
  }
}

// Création d'une tâche DOM avec bouton "X" pour supprimer
function createTaskElement(task) {
  const div = document.createElement("div");
  div.className = `border-l-4 p-3 rounded-lg shadow cursor-move select-none flex justify-between items-center ${getPriorityClasses(
    task.priority
  )}`;
  div.dataset.id = task.id;
  div.draggable = true;

  // Nom de la tâche
  const span = document.createElement("span");
  span.textContent = task.name;

  // Bouton "X" pour supprimer (envoyer à la corbeille)
  const btn = document.createElement("button");
  btn.textContent = "✕";
  btn.className =
    "ml-3 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 font-bold";
  btn.title = "Envoyer à la corbeille";
  btn.addEventListener("click", (e) => {
    e.stopPropagation();
    moveToTrash(task.id);
  });

  div.appendChild(span);
  div.appendChild(btn);

  // Drag events
  div.addEventListener("dragstart", (e) => {
    e.dataTransfer.setData("text/plain", task.id);
    e.dataTransfer.effectAllowed = "move";
  });

  return div;
}

function renderBoard() {
  const columns = board.querySelectorAll(".column");
  columns.forEach((column) => {
    const status = column.dataset.status;
    const list = column.querySelector(".list");
    list.innerHTML = "";

    let filteredTasks = tasks.filter((t) => t.status === status);

    const filterText = filterInput.value.toLowerCase();
    if (filterText) {
      if (filterBy.value === "name") {
        filteredTasks = filteredTasks.filter((t) =>
          t.name.toLowerCase().includes(filterText)
        );
      } else if (filterBy.value === "priority") {
        filteredTasks = filteredTasks.filter((t) =>
          t.priority.toLowerCase().includes(filterText)
        );
      }
    }

    filteredTasks.forEach((task) => {
      const taskEl = createTaskElement(task);
      list.appendChild(taskEl);
    });

    // Setup dragover and drop events on lists to handle drop
    list.addEventListener("dragover", (e) => {
      e.preventDefault();
      e.dataTransfer.dropEffect = "move";
    });

    list.addEventListener("drop", (e) => {
      e.preventDefault();
      const taskId = e.dataTransfer.getData("text/plain");
      const task = tasks.find((t) => t.id === taskId);
      if (!task) return;
      if (task.status !== status) {
        task.status = status;
        renderBoard();
      }
    });
  });
}

function renderTrash() {
  trashList.innerHTML = "";

  trash.forEach((task) => {
    const div = document.createElement("div");
    div.className = `border-l-4 p-3 rounded-lg shadow cursor-pointer select-none flex justify-between items-center ${getPriorityClasses(
      task.priority
    )}`;
    div.textContent = task.name;
    div.dataset.id = task.id;

    // Restaurer la tâche en double cliquant
    div.addEventListener("dblclick", () => {
      restoreFromTrash(task.id);
    });

    trashList.appendChild(div);
  });
}

addBtn.addEventListener("click", () => {
  const name = taskNameInput.value.trim();
  const priority = taskPrioritySelect.value;

  if (!name) return alert("Le nom de la tâche est requis");

  const newTask = {
    id: Date.now().toString(),
    name,
    priority,
    status: "TO DO",
  };

  tasks.push(newTask);
  taskNameInput.value = "";
  renderBoard();
});

emptyTrashBtn.addEventListener("click", () => {
  if (trash.length === 0) {
    alert("La corbeille est déjà vide.");
    return;
  }
  if (
    confirm(
      "Êtes-vous sûr de vouloir vider la corbeille ? Cette action est irréversible."
    )
  ) {
    trash = [];
    renderTrash();
  }
});

function moveToTrash(id) {
  const index = tasks.findIndex((t) => t.id === id);
  if (index === -1) return;

  const [task] = tasks.splice(index, 1);
  trash.push(task);

  renderBoard();
  renderTrash();
}

function restoreFromTrash(id) {
  const index = trash.findIndex((t) => t.id === id);
  if (index === -1) return;

  const [task] = trash.splice(index, 1);
  tasks.push(task);

  renderBoard();
  renderTrash();
}

filterInput.addEventListener("input", renderBoard);
filterBy.addEventListener("change", renderBoard);

toggleDarkBtn.addEventListener("click", () => {
  document.documentElement.classList.toggle("dark");
});

renderBoard();
renderTrash();
