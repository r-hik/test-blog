 <?php if(isset($_COOKIE['sid']))
    {
      $sql  =   "SELECT * FROM connexion WHERE sid='".$_COOKIE['sid']."'";  
      $result =   mysql_query($sql);

      if(mysql_num_rows($result))
        {
          $connecte   =   true;
          $utilisateur  =   mysql_fetch_array($result);
        } 
    } ?>
 </div>
          
          <nav class="span4">
            <h2>Menu</h2>
            <form action="index.php" method="get">
              <label for="rech">Recherche: </label>
              <?php
              $rech=htmlspecialchars(var_get('r'));
              if ($rech) {
                echo '<input type="text" name="r" id="rech" value="'.$rech.'" class="span3">&nbsp;';
              }
              
              else echo '<input type="text" name="r" id="rech" placeholder="mots à rechercher" class="span3">&nbsp;';
              ?>
              <input type="submit" value="OK" class="btn">
            </form>
            <ul>
                <li><button class='btn btn-success btn-small' id='menuaccueil' >Accueil</a></li>
                <?php if ($connecte)
                {
                echo "<li><button class='btn btn-success btn-small' id='menuarticle' >Rédiger un article</a></li>";
                }
                ?>
            </ul>
            <h2>Playlist</h2>
      <object data="player/dewplayer-vinyl.swf" width="303" height="113" name="dewplayer" id="dewplayer" type="application/x-shockwave-flash">
      <param name="wmode" value="opaque" />
      <param name="movie" value="player/dewplayer-vinyl.swf" />
      <param name="flashvars" value="showtime=true&autoreplay=true&autoplay=false&xml=player/playlist.xml" />
      <param name="bgcolor" value="#ff0000"/>
      </object>
            
          </nav>
          
        </div>
        
      </div>

      <footer>
        <p>&copy; R-hik 2012</p>

      </footer>

    </div>
</div>
<script src="jquery.js"></script>
<script>
  $(function() {
    $('#menuarticle').click(function() {
      $('#body').load('article.php', function() {
      });
    });

    $('#menuaccueil').click(function() {
      $('#body').load('index.php', function() {
      });
    });
  });
</script>
        
      
  </body>
</html>