<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Exemple</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gradient-to-r from-violet-700 to-violet-500 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <h1 class="text-3xl font-extrabold text-center text-violet-700 mb-6">LOGIN</h1>
        <form action="login_process.php" method="post" class="space-y-6">
            <!-- Champ Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email :</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        class="block w-full px-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-violet-500 focus:border-violet-500">
                </div>
            </div>
            <!-- Champ Mot de Passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe :</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        class="block w-full px-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-violet-500 focus:border-violet-500">
                </div>
            </div>

            <!-- Bouton Soumettre -->
            <div>
                <button 
                    type="submit" 
                    class="w-full bg-violet-700 text-yellow-300 font-bold py-2 px-4 rounded-lg shadow hover:bg-violet-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                    Soumettre
                </button>
            </div>
        </form>
    </div>
</body>
</html>
