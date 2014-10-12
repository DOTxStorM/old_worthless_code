<div id='header_wrapper'>
	<div class = "menu" id="header">
	
        <div class="header_section">
            <a href="home.php"><h2 id="storyblox" >StoryBlox</h2></a>
        </div>
        
        <div class="header_section" >
        	<a class="menu_button" href="home.php">Home</a>
            <a class="menu_button" href="createStory.php">Create Story</a>
            <a class="menu_button" href="myStories.php">My Stories</a>
        </div>
        
        <!-- make own css class for search -->
        <div class="header_section" style="margin-top:10px; margin-left:10px">
            <form id="search" method="get" action="searchResults.php">
                <input type="text" name="search_input" style = "color:#39F; background-color:#9CF; border: solid 0px" 
                		placeholder="Search by title and tags"/>
                <button type="button"  id="search_button" onclick="this.form.submit()"><b>Search</b></button>
            </form>
        </div>

        <div class="header_section" id="create_story">
           
            <a class="menu_button" href="profile.php"><strong><?php echo $_SESSION['username']; ?></strong></a>
            <a class="menu_button" href='index.php?exit=0'>Log Out</a>
        </div>
    </div>
</div>

