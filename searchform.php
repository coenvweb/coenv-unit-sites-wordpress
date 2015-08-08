<form role="search" method="get" class="search-form Form--inline" action="<?php echo home_url( '/' ); ?>">
  <div class="field-wrap">
	<label for="s">Search Field</label>
    <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Search this site" />
    <button type="submit"><i class="fi-magnifying-glass"></i><span>Search</span></button>
  </div>
</form>