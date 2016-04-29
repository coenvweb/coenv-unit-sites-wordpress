<form role="search" method="get" class="search-form Form--inline" action="<?php echo home_url( '/' ); ?>">
  <div class="field-wrap">
	<input type="text" value="<?php echo get_search_query() ?>" name="s" placeholder="Search this site" aria-label="Search" title="Search"/>
    <button type="submit"><i class="fi-magnifying-glass"></i><span>Search</span></button>
  </div>
</form>