<?php
// Partiamo da questo array di hotel. 
// https://www.codepile.net/pile/OEWY7Q1G
// Stampare tutti i nostri hotel con tutti 
// i dati disponibili.

// Iniziate in modo graduale.
// Prima stampate in pagina i dati, senza 
// preoccuparvi dello stile.
// Dopo aggiungete Bootstrap e mostrate 
// le informazioni con una tabella.

// Bonus:
// 1 - Aggiungere un form ad inizio pagina 
// che tramite una richiesta GET permetta di 
// filtrare gli hotel che hanno un parcheggio.

// 2 - Aggiungere un secondo campo al form 
// che permetta di filtrare gli hotel per voto 
// (es. inserisco 3 ed ottengo tutti gli hotel che hanno un voto di tre stelle o superiore)

// NOTA: deve essere possibile utilizzare 
// entrambi i filtri contemporaneamente (es. ottenere 
// una lista con hotel che dispongono di parcheggio e 
// che hanno un voto di tre stelle o superiore)
// Se non viene specificato nessun filtro, visualizzare 
// come in precedenza tutti gli hotel.

$hotels = [
    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ],
];

// Intanto mi prendo la lista intera degli hotel
// se c'è il filtro del parcheggio mi segno in un altro "foglio" solo gli hotel
// col parcheggio e stampo quelli
$parking_filter = isset($_GET['parking']) && $_GET['parking'] === '1' ? true : false;
$vote_filter = isset($_GET['vote']) ? intval($_GET['vote']) : 0;

$filteredHotels = $hotels;

if($parking_filter) {
    $hotelsWithParking = [];
    foreach($filteredHotels as $hotel) {
        if($hotel['parking'] === true) {
            $hotelsWithParking[] = $hotel;
        }
    }

    $filteredHotels = $hotelsWithParking;
}

// se c'è il filtro del voto
// ci creiamo un array di appoggio dove salviamo gli hotel con un voto 
// uguale o maggiore al filtro
if($vote_filter > 0) {
    $hotelsFilteredByVote = [];

    foreach($filteredHotels as $hotel) {
        if($hotel['vote'] >= $vote_filter) {
            $hotelsFilteredByVote[] = $hotel;
        }
    }

    $filteredHotels = $hotelsFilteredByVote;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    <div class="container py-5">
        <h3>Filtra gli Hotel</h3>
        <form method="GET">
            <div class="mb-3 form-check">
                <input type="checkbox" <?php echo $parking_filter ? 'checked' : ''; ?> class="form-check-input" id="parking" name="parking" value="1">
                <label class="form-check-label" for="parking">Con parcheggio</label>
            </div>

            <div class="mb-3">
                <label for="vote" class="form-label">Voto</label>
                <select id="vote" class="form-select" name="vote">
                    <option <?php echo $vote_filter === 0 ? 'selected' : '' ?> value="0">Tutti</option>
                    <option <?php echo $vote_filter === 1 ? 'selected' : '' ?> value="1">Almeno 1</option>
                    <option <?php echo $vote_filter === 2 ? 'selected' : '' ?> value="2">Almeno 2</option>
                    <option <?php echo $vote_filter === 3 ? 'selected' : '' ?> value="3">Almeno 3</option>
                    <option <?php echo $vote_filter === 4 ? 'selected' : '' ?> value="4">Almeno 4</option>
                    <option <?php echo $vote_filter === 5 ? 'selected' : '' ?> value="5">Almeno 5</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrizione</th>
                    <th>Parcheggio</th>
                    <th>Voto</th>
                    <th>Distanza dal centro</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($filteredHotels as $hotel) { ?>
                    <?php //var_dump($hotel); ?>
                    <tr>
                        <td><?php echo $hotel['name']; ?></td>
                        <td><?php echo $hotel['description']; ?></td>
                        <td><?php echo $hotel['parking'] ? 'Si' : 'No'; ?></td>
                        <td><?php echo $hotel['vote']; ?></td>
                        <td><?php echo $hotel['distance_to_center']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>