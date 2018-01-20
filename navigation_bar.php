<div class="topnav">
    <a href="index.php"><?php
            if(!empty($_SESSION['member_name'])) {
                echo $_SESSION['member_name'] . "'s ";
            }
        ?>Home</a>
    <a href="songs.php">Songs</a>
    <a href="artists.php">Artists</a>
    <a href="albums.php">Albums</a>
    <a href="people.php">People</a>
    <a href="playlists.php">Playlists</a>
    <div class="search-container">
        <form action="songs.php">
            <select class="select" name="searchType">
                <option value="song">Song</option>
                <option value="genre">Genre</option>
                <option value="artist">Artist</option>
                <option value="album">Album</option>
            </select>
            <input type="text" placeholder="Search..." name="search">
            <button type="submit">Go</button>
        </form>
    </div>
</div>