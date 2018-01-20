<div class="pagination">
    <br>
    <?php
    $last = ceil($conn->query($sql)->fetch_assoc()["c"]/10);
    $url= htmlspecialchars($_SERVER["PHP_SELF"]);
    $page = !isset($_GET["page"]) ? 1: $_GET["page"];
    $page_to_show = 10;

    if($last < 10){
        for ($i = 1; $i <= $last; $i++) {
            echo "<a href=\"$url?page=$i$url_add\"";
            if ($page == $i) {
                echo "class=\"active\"";
            }
            echo ">$i</a>";
        }
    }
    else {
        if ($page == 1) {
            for ($i = 1; $i <= $page_to_show; $i++) {
                echo "<a href=\"$url?page=$i$url_add\"";
                if ($page == $i) {
                    echo "class=\"active\"";
                }
                echo ">$i</a>";
            }
            echo "<a href=\"$url?page=$last$url_add\">&raquo;</a>";
        } else if ($page > $last - $page_to_show) {
            echo "<a href=\"$url?page=1$url_add\">&laquo;</a>";
            for ($i = $last - $page_to_show; $i <= $last; $i++) {
                echo "<a href=\"$url?page=$i$url_add\"";
                if ($page == $i) {
                    echo "class=\"active\"";
                }
                echo ">$i</a>";
            }
        } else {
            echo "<a href=\"$url?page=1\">&laquo;</a>";
            for ($i = $page - 1; $i < $page + $page_to_show - 1; $i++) {
                echo "<a href=\"$url?page=$i$url_add\"";
                if ($page == $i) {
                    echo "class=\"active\"";
                }
                echo ">$i</a>";
            }
            echo "<a href=\"$url?page=$last$url_add\">&raquo;</a>";
        }
    }
    ?>

</div>