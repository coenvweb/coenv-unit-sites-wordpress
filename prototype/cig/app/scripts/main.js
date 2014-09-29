// Read a page's GET URL variables and return them as an associative array.
function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
function eachWord(str){
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}
var title_raw = getUrlVars() ['title'];
var title_page;
var parent_raw = getUrlVars() ['parent'];
var parent_page;
var level_raw = getUrlVars() ['lvl'];
if (title_raw) {
	var title_page = title_raw.replace(/_/g, ' ');
	var title_page = eachWord(title_page);
}
if (parent_raw) {
    var parent_page = parent_raw.replace(/_/g, ' ');
    var parent_page = eachWord(parent_page);
}

// excel spreadsheet using custom "''"@"''"+
if (parent_raw) {
    if (parent_raw == 'about') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='/prototypes/cig/content.html?title=what_we_do&parent=about'>What We Do</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=our_impact&parent=about'>Our Impact</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=partnering_with_cig&parent=about'>Partnering with CIG</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=cig_at_uw&parent=about'>CIG at UW</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=people&parent=about'>People</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=donate&parent=about'>Donate</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=contact_us&parent=about'>Contact Us</a></li>"+
            "</ul>";

    } else if (parent_raw == 'our_work') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='/prototypes/cig/content.html?title=climate_dynamics&parent=our_work'>Climate Dynamics</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=regional_climate_modeling&parent=our_work'>Regional Climate Modeling</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=impacts_assessment&parent=our_work'>Impacts Assessment</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=technical_consultation_and_outreach&parent=our_work'>Technical Consultation & Outreach</a></li>"+
            "</ul>";

    }  else if (parent_raw == 'learn') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='/prototypes/cig/content.html?title=climate_variability&parent=learn'>Climate Variability</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=climate_change&parent=learn'>Climate Change</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=climate_change_impacts_in_brief&parent=learn'>Climate Change Impacts in Brief</a></li>"+
            "</ul>";
        
    } else if (parent_raw == 'prepare') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='/prototypes/cig/content.html?title=why_adapt&parent=prepare'>Why Adapt?</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=adaptation_concepts_and_processes&parent=prepare'>Adaptation Concepts & Processes</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=adaptation_in_action&parent=prepare'>Adaptation in Action</a></li>"+
            "</ul>";
        
    } else if (parent_raw == 'data') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='/prototypes/cig/content.html?title=choosing_and_using_climate_data&parent=data'>Choosing & Using Climate Data</a></li>"+
			"<li><a href='/prototypes/cig/data.html?title=cig_datasets&parent=data'>CIG Datasets</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=decision_support_tools&parent=data'>Decision Support Tools</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=publications&parent=data'>Publications</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=special_reports&parent=data'>Special Reports</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=other_resources&parent=data'>Other Resources</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=graphics_library&parent=data'>Graphics Library</a></li>"+
            "</ul>";
        
    } else if (parent_raw == 'news_and_events') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='/prototypes/cig/content.html?title=seminars_conferences_and_events&parent=news_and_events'>Seminars, Conferences, & Events</a></li>"+
			"<li><a href='/prototypes/cig/content.html?title=news_and_media&parent=news_and_events'>News & Media</a></li>"+
            "</ul>";
        
    } else {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li>"+"<a href='/prototypes/cig#'>Link one</a></li>\n"+
            "<li>"+"<a href='/prototypes/cig#'>Link two</a></li>\n"+
            "<li>"+"<a href='/prototypes/cig#'>Link three</a></li>\n"+ 
            "<li>"+"<a href='/prototypes/cig#'>Link four</a></li>\n"+
            "</ul>";
    }
} 



$( document ).ready(function() {
/* Mobile menu accordion */
	$("ul.off-canvas-list label").siblings(".sub-menu").hide();
	$("ul.off-canvas-list label").on("click", function(){
		$(this).siblings(".sub-menu").slideToggle();
	});
/* Quick and messy dynamic breadcrumbs, page titles, and subnavs */
	$( "h1.page-title" ).html( title_page );
    if (parent_page != title_page) {
        $( ".breadcrumbs li.parent a").html(parent_page);
    } else {
        $( ".breadcrumbs li.parent").hide();
    }




    $( ".breadcrumbs li.current").html(title_page);
    $( "#side-nav").html(page_subnav);
});