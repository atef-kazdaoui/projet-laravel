<html>
    <div class="les evenements">
    </div>
    <div class="ajouter des evenemtents">
        <!-- Exemple de formulaire dans home.blade.php -->
        <form action="{{ route('evenement.post') }}" method="post" id="eventForm">
            @csrf
            <!-- Ajoutez un champ caché pour le token -->
            <input type="hidden" name="token" id="token" value="{{ auth()->user()->api_token }}">
            <input type="text" name="title" id="title" placeholder="Titre" required>
            <textarea name="description" id="description" placeholder="Description" required></textarea>
            <input type="date" name="date" id="date" required>
            <input type="text" name="location" id="location" placeholder="Lieu" required>
            <button type="submit">Ajouter l'événement</button>
        </form>
    </div>
    <!-- Ajout temporaire pour tester la valeur du token -->
<div>Token Test: {{ auth()->user()->api_token ?? 'No Token Found' }}</div>

    
    <!-- Utilisez un script JavaScript pour récupérer les valeurs des champs input au moment de la soumission du formulaire -->
    <script>
        document.getElementById('eventForm').addEventListener('submit', function(event) {
            // Récupérez la valeur du token
            var token = document.getElementById('token').value;
            // Récupérez la valeur du titre
            var title = document.getElementById('title').value;
            var description = document.getElementById('description').value;
            var date = document.getElementById('date').value;
            var location = document.getElementById('location').value;
            // Affichez les valeurs dans la console
            console.log('Token:', token);
            console.log('Title:', title);
            console.log('description:',description);
            console.log('date :',date);
            console.log('location :',location);
            
            
        });
    </script>
</html>
