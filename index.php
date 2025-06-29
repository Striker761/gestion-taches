<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8" />
  <title>Gestion de Tâches</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class', // Activation mode sombre par classe "dark"
    }
  </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 p-6 font-sans transition-colors duration-300">

  <!-- Bouton mode sombre en fixed en haut à droite -->
  <button id="toggleDarkBtn"
          class="fixed top-4 right-4 bg-gray-800 dark:bg-gray-700 text-white dark:text-gray-200 px-3 py-1 rounded-md
                 hover:bg-gray-900 dark:hover:bg-gray-600 transition text-sm z-50">
    Mode Sombre
  </button>

  <div id="form" class="max-w-4xl mx-auto flex flex-col sm:flex-row justify-center items-center gap-4 mb-10">
    <input id="taskName" placeholder="Nom de la tâche"
           class="flex-grow px-5 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm
                  bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500
                  focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
    <select id="taskPriority"
            class="w-40 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm
                   bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200
                   focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
      <option value="LOW">LOW</option>
      <option value="MEDIUM">MEDIUM</option>
      <option value="HIGH">HIGH</option>
    </select>
    <button id="addBtn"
            class="bg-blue-600 dark:bg-blue-700 text-white dark:text-gray-200 px-6 py-3 rounded-lg shadow-lg
                   hover:bg-blue-700 dark:hover:bg-blue-600 active:scale-95 transition-transform">
      Ajouter
    </button>
  </div>

  <div class="flex items-center gap-3 mb-4 max-w-4xl mx-auto">
    <input id="filterInput" type="text" placeholder="Filtrer..."
           class="px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                  bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500
                  focus:outline-none focus:ring-2 focus:ring-blue-400 w-40 text-sm transition" />

    <select id="filterBy"
            class="px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                   bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200
                   focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm transition">
      <option value="name">Par mot (nom)</option>
      <option value="priority">Par priorité</option>
    </select>
  </div>

  <div id="board" class="max-w-6xl mx-auto flex flex-wrap justify-between gap-6">
    <div class="column bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 w-full sm:w-[48%] lg:w-[23%]"
         data-status="TO DO">
      <h3 class="text-center font-extrabold text-gray-700 dark:text-gray-200 text-lg mb-5 tracking-wide">TO DO</h3>
      <div class="list min-h-[160px] space-y-3"></div>
    </div>

    <div class="column bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 w-full sm:w-[48%] lg:w-[23%]"
         data-status="IN PROGRESS">
      <h3 class="text-center font-extrabold text-gray-700 dark:text-gray-200 text-lg mb-5 tracking-wide">IN PROGRESS</h3>
      <div class="list min-h-[160px] space-y-3"></div>
    </div>

    <div class="column bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 w-full sm:w-[48%] lg:w-[23%]"
         data-status="IN REVIEW">
      <h3 class="text-center font-extrabold text-gray-700 dark:text-gray-200 text-lg mb-5 tracking-wide">IN REVIEW</h3>
      <div class="list min-h-[160px] space-y-3"></div>
    </div>

    <div class="column bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 w-full sm:w-[48%] lg:w-[23%]"
         data-status="DONE">
      <h3 class="text-center font-extrabold text-gray-700 dark:text-gray-200 text-lg mb-5 tracking-wide">DONE</h3>
      <div class="list min-h-[160px] space-y-3"></div>
    </div>
  </div>

  <div id="trash" class="max-w-4xl mx-auto mt-14 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
    <h3 class="text-center font-extrabold text-red-600 dark:text-red-400 text-xl mb-6 tracking-wide">Corbeille</h3>
    <div id="trashList" class="min-h-[110px] space-y-2"></div>

    <!-- Bouton Vider la corbeille -->
    <button id="emptyTrashBtn"
            class="mt-4 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 active:scale-95 transition-transform
                   shadow-md w-full max-w-xs mx-auto block">
      Vider la corbeille
    </button>

  </div>

  <script src="js.js"></script>
</body>
</html>
