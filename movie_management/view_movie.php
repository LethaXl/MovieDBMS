<?php
include 'connect.php';

if (!$conn) {
    echo "Failed to connect to the database.";
    exit;
}


$query = "SELECT MOVIE_ID, TITLE, RATING, GENRE, PRICE_PURCHASE, PRICE_RENTAL FROM MOVIE"; 
$stid = oci_parse($conn, $query);

if (!$stid) {
    echo "Error parsing query: " . oci_error($conn)['message'];
    oci_close($conn);
    exit;
}

$r = oci_execute($stid);

if (!$r) {
    echo "Error executing query: " . oci_error($stid)['message'];
    oci_close($conn);
    exit;
}


$movieImages = [
    'Wonder Woman' => 'https://posters.movieposterdb.com/21_11/2017/451279/s_451279_32b6f6ba.jpg',
    'Aquaman' => 'https://posters.movieposterdb.com/20_05/2018/1477834/s_1477834_325d69d5.jpg',
    'Spider-Man: No Way Home' => 'https://posters.movieposterdb.com/21_12/2021/10872600/s_10872600_c809b67f.jpg',
    'Black Widow' => 'https://posters.movieposterdb.com/22_07/2021/12204958/s_12204958_1234c2a2.jpg',
    'Deadpool' => 'https://posters.movieposterdb.com/24_11/2016/1431045/s_deadpool-movie-poster_51930392.jpg',
    'X-Men: Days of Future Past' => 'https://posters.movieposterdb.com/14_06/2014/1877832/s_1877832_04aaf850.jpg',
    'Guardians of the Galaxy Vol. 2' => 'https://posters.movieposterdb.com/20_08/2017/3896198/s_3896198_b002fe3d.jpg',
    'Thor: Ragnarok' => 'https://posters.movieposterdb.com/22_05/2017/3501632/s_3501632_a7aaa3d6.jpg',
    'Avengers: Endgame' => 'https://posters.movieposterdb.com/23_06/2019/4154796/s_avengers-endgame-movie-poster_21dfd2d6.jpg',
    'Black Panther' => 'https://posters.movieposterdb.com/22_06/2018/1825683/s_1825683_d608586c.jpg',
    'Captain Marvel' => 'https://posters.movieposterdb.com/20_06/2018/4154664/s_4154664_5d0f2b92.jpg',
    'Shazam!' => 'https://posters.movieposterdb.com/20_01/2019/448115/s_448115_dfc6c3a2.jpg',
    'The Flash' => 'https://posters.movieposterdb.com/23_06/2023/439572/s_the-flash-movie-poster_e7957c79.jpg',
    'The Suicide Squad' => 'https://posters.movieposterdb.com/21_06/2021/6334354/s_6334354_bece6685.jpg',
    'Venom' => 'https://posters.movieposterdb.com/22_02/2018/1270797/s_1270797_9f748b5b.jpg',
    'Morbius' => 'https://posters.movieposterdb.com/22_02/2022/5108870/s_5108870_e0fdcf2c.jpg',
    'Spider-Man: Into the Spider-Verse' => 'https://posters.movieposterdb.com/22_10/2018/4633694/s_spider-man-into-the-spider-verse-movie-poster_a7f62b30.jpeg',
    'Teen Titans Go! To the Movies' => 'https://posters.movieposterdb.com/21_10/2018/7424200/s_7424200_fd143927.jpg',
    'Kung Fu Panda' => 'https://posters.movieposterdb.com/08_10/2008/441773/s_441773_40053b4b.jpg',
    'How to Train Your Dragon' => 'https://posters.movieposterdb.com/12_02/2010/892769/l_892769_9de942c2.jpg',
    'Inception' => 'https://posters.movieposterdb.com/10_06/2010/1375666/s_1375666_07030c72.jpg',
    'The Dark Knight' => 'https://posters.movieposterdb.com/08_06/2008/468569/l_468569_fe24b125.jpg',
    'The Godfather' => 'https://posters.movieposterdb.com/22_07/1972/68646/s_68646_8c811dec.jpg',
    'The Shawshank Redemption' => 'https://posters.movieposterdb.com/05_03/1994/0111161/s_8494_0111161_3bb8e662.jpg',
    'Pulp Fiction' => 'https://posters.movieposterdb.com/07_10/1994/110912/s_110912_55345443.jpg',
    'The Matrix' => 'https://posters.movieposterdb.com/06_01/1999/0133093/s_77607_0133093_ab8bc972.jpg',
    'Jurassic Park' => 'https://posters.movieposterdb.com/05_08/1993/0107290/s_45298_0107290_be4e0db3.jpg',
    'Fight Club' => 'https://posters.movieposterdb.com/13_06/1999/137523/l_137523_1d292ea3.jpg',
    'The Avengers' => 'https://posters.movieposterdb.com/20_10/2012/848228/s_848228_9bc5bc2a.jpg',
    'Toy Story' => 'https://posters.movieposterdb.com/13_05/1995/114709/s_114709_6645f9fc.jpg',
    'Smile 2' => 'https://posters.movieposterdb.com/24_06/2024/29268110/l_smile-2-movie-poster_07452b6b.jpg',
    'The Wild Robot' => 'https://posters.movieposterdb.com/24_08/2024/29623480/s_the-wild-robot-movie-poster_ec4bfce0.jpg',
    'The Prestige' => 'https://posters.movieposterdb.com/08_04/2006/482571/s_482571_2bc9641a.jpg',
    'Nightcrawler' => 'https://posters.movieposterdb.com/14_10/2014/2872718/s_2872718_aee24518.jpg'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
    <style>
        /* Copy the CSS provided earlier */
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@600&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
            color: #f8f8f8;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
            color: #1db954;
        }

        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            width: 100%;
            max-width: 1200px;
        }

        .movie-card {
            background-color: #1e1e1e;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: auto; /* Auto height based on content */
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.6);
        }

        .movie-card img {
            width: 100%;
            height: 100%; /* Fixed image height */
            object-fit: cover;
        }

        .movie-card .movie-title {
            padding: 15px;
            text-align: center;
            font-size: 1.4rem;
            font-weight: bold;
            color: #f8f8f8;
            font-family: 'Montserrat', sans-serif;
            background-color: #333; /* Subtle background for title */
        }

        .movie-card .movie-details {
            padding: 15px;
            font-size: 1rem;
            color: #f8f8f8;
            font-family: 'Roboto', sans-serif;
            text-align: left; /* Align to left for better readability */
        }

        .movie-card .movie-details p {
            margin: 8px 0;
        }

        .movie-card .movie-details span {
            font-weight: bold;
            color: #1db954; /* Highlight the labels in green */
        }

        .movie-card .no-image {
            padding: 15px;
            text-align: center;
            color: #f8f8f8;
            font-size: 1rem;
            font-family: 'Roboto', sans-serif;
            background-color: #333;
            border-radius: 8px;
        }

        .back-link {
            text-decoration: none;
            color: #121212;
            background-color: #f39c12;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background-color: #d35400;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(243, 156, 18, 0.5);
        }
    </style>
</head>
<body>
    <h1>Movies List</h1>

    <div class="movie-grid">
        <?php while ($row = oci_fetch_assoc($stid)): ?>
            <div class="movie-card">
                <?php 
                    $title = $row['TITLE'];
                    $movieId = $row['MOVIE_ID'];
                    $imageUrl = isset($movieImages[$title]) ? $movieImages[$title] : ''; 
                ?>
                <img src="<?= $imageUrl ?: 'https://via.placeholder.com/250x300.png?text=No+Image' ?>" alt="<?= $title ?>">
                <div class="movie-title"><?= htmlspecialchars($title) ?></div>
                <div class="movie-details">
                    <p><span>Movie ID:</span> <?= htmlspecialchars($movieId) ?></p>
                    <p><span>Rating:</span> <?= htmlspecialchars($row['RATING']) ?></p>
                    <p><span>Genre:</span> <?= htmlspecialchars($row['GENRE']) ?></p>
                    <p><span>Price to Rent:</span> $<?= htmlspecialchars($row['PRICE_RENTAL']) ?></p>
                    <p><span>Price to Buy:</span> $<?= htmlspecialchars($row['PRICE_PURCHASE']) ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <a href="index.php" class="back-link">Back to Home</a>

    <?php 
   
    oci_free_statement($stid);
    oci_close($conn); 
    ?>
</body>
</html>
