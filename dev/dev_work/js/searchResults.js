     
    
    
   /**
    *creates and sets page links depending on number of results found(10 results max per page)
    */
   function setPages(p_current_page_num, p_num_pages, p_search_string){
        try{
            var page_num_list = document.getElementById("pageNumberLinks");
            var page_counter = 1;
            var page = "page";
            var path= "searchResults.php?";
    
            while(page_counter <= p_num_pages){
                var new_page = document.createElement('li');
                var page_link = document.createElement('a');
                var page_number = document.createTextNode(page_counter);
                var location = path + "searchInput="+p_search_string + "&page=" + (page_counter); 
                page_link.href = location;
                new_page.appendChild(page_link);
                page_link.appendChild(page_number);
                new_page.className = "pageNum";
                new_page.id = page + (page_counter);
                page_num_list.insertBefore(new_page,document.getElementById("next"));
 
                if(page_counter == p_current_page_num){
                    new_page.className = "active";
                }
                page_counter++;
            }  
        }
        catch(e) {
                     log("searchResults.js", e.lineNumber, e);
        }
    }
    
    /*
     * displays previous page button if there is a page to go to before current page, hides button otherwise
     */
    function setPrevious(p_page_num, p_search_string){
    	try{
            var previous = document.getElementById("previous");
            var prev_link = document.getElementById("prev_link");
            if(p_page_num == 1){
                 previous.style.display = "none";
            }else{
                var previous_page = p_page_num - 1;
                previous.style.display = "inline";
                prev_link.href = "searchResults.php?searchInput=" + p_search_string + "&" + "page=" + previous_page;
            }
    	}
    	catch(e) {
			log("searchResults.js", e.lineNumber, e);
    	}
    }
    
    /*
     * displays next page button if there is more than one total page, or current page is not last page, hides button otherwise
     */
    function setNext(p_page_num, p_num_pages, p_search_string){
    	try {
            var next = document.getElementById("next");
            var next_link = document.getElementById("next_link");
            if(p_page_num == p_num_pages){
                next.style.display = "none";
            }else{
                var next_page = p_page_num + 1;
                next.style.display = "inline";
                next_link.href = "searchResults.php?searchInput=" + p_search_string + "&" + "page=" + next_page;
            }
    	}
    	catch(e) {
			log("searchResults.js", e.lineNumber, e);
    	}
    }
    
    /*
     * displays total number of stories found for query above results table
     */
    function displayNumResults(){
    	try {
        var num_results_div = document.getElementById("num_results");
        num_results_div.style.borderBottom = "1px solid #aaa";
    	}
    	catch (e) {
			log("searchResults.js", e.lineNumber, e);
    	}
    }

