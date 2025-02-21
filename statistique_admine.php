<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Statistics</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-500 to-purple-600 font-sans leading-normal tracking-normal text-white">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-5xl font-extrabold text-center mb-12">Tableau de Bord - Statistiques</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white text-gray-800 rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform duration-300">
                <h2 class="text-xl font-bold">Total Utilisateurs</h2>
                <p class="text-5xl font-extrabold text-blue-600">{{total_utilisateurs}}</p>
                <p class="mt-2 text-gray-500">Membres inscrits</p>
            </div>
            <div class="bg-white text-gray-800 rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform duration-300">
                <h2 class="text-xl font-bold">Total Projets</h2>
                <p class="text-5xl font-extrabold text-green-600">{{total_projets}}</p>
                <p class="mt-2 text-gray-500">Projets en cours</p>
            </div>
            <div class="bg-white text-gray-800 rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform duration-300">
                <h2 class="text-xl font-bold">Total Tâches</h2>
                <p class="text-5xl font-extrabold text-yellow-600">{{total_taches}}</p>
                <p class="mt-2 text-gray-500">Tâches assignées</p>
            </div>
            <div class="bg-white text-gray-800 rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform duration-300">
                <h2 class="text-xl font-bold">Total Commentaires</h2>
                <p class="text-5xl font-extrabold text-red-600">{{total_commentaires}}</p>
                <p class="mt-2 text-gray-500">Commentaires ajoutés</p>
            </div>
        </div>

        <div class="mt-16">
            <h2 class="text-3xl font-bold text-center mb-6">Statistiques Avancées</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white text-gray-800 rounded-xl shadow-lg p-8">
                    <h3 class="text-2xl font-semibold">Répartition des Statuts des Projets</h3>
                    <div class="mt-4">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
                <div class="bg-white text-gray-800 rounded-xl shadow-lg p-8">
                    <h3 class="text-2xl font-semibold">Progression des Projets</h3>
                    <div class="mt-4">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx1 = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['En cours', 'Terminé', 'En attente'],
                datasets: [{
                    data: [50, 30, 20], // Exemple de données
                    backgroundColor: ['#4CAF50', '#FF9800', '#F44336']
                }]
            }
        });

        const ctx2 = document.getElementById('progressChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Projet A', 'Projet B', 'Projet C'],
                datasets: [{
                    label: 'Progression (%)',
                    data: [70, 45, 90], // Exemple de données
                    backgroundColor: ['#2196F3', '#3F51B5', '#009688']
                }]
            }
        });
    </script>
</body>
</html>
