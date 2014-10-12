<div class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#first_logged_in">
      <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">StoryBlox</a>
    </div>
    <div class="navbar-collapse collapse" id="first_logged_in">
      <ul class="nav navbar-nav navbar-left">
        <li><a href="home.php">Home</a></li>
        <li><a href="createStory.php">Create Story</a></li>
        <li><a href="myStories.php">My Stories</a></li>
      </ul>
          <form class="navbar-form navbar-left" role="form" action="searchResults.php" method="get">
            <div class="form-group">
              <input name="searchInput" type="text" placeholder="Search by title and tags" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary" onclick="this.form.submit()" style="background:transparent">Search</button>
          <!--<button type="btn" id="search_button" onclick="this.form.submit()"><b>Search</b></button> -->
          </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><strong><?php echo $_SESSION['username']; ?></strong></a></li>
        <li><a href="index.php?exit=0">Log Out</a></li>
      </ul>
    </div>
  </div>
</div>