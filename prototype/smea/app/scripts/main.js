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
            "<li><a href='content.html?title=about_the_school&parent=about'>About the School</a></li>"+
			"<li><a href='content.html?title=our_director&parent=about'>Our Director</a></li>"+
            "<li><a href='news.html?title=news&parent=about'>News</a></li>"+
            "<li><a href='content.html?title=events&parent=about'>Events</a></li>"+
            "<li><a href='content.html?title=connect_with_us&parent=about'>Connect with Us</a></li>"+
            "<li><a href='content.html?title=give&parent=about'>Give</a></li>"+
            "<li><a href='content.html?title=staff&parent=about'>Staff</a></li>"+
            "<li><a href='content.html?title=contact_us&parent=about'>Contact Us</a></li>"+
        "</ul>";
    } else if (parent_raw == 'program') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='content.html?title=why_a_masters_in_marine_affairs&parent=program'>Why a Masters in Marine Affairs?</a></li>"+
			"<li><a href='content.html?title=student_faqs&parent=program'>Student FAQs</a></li>"+
            "<li><a href='profiles.html?title=student_profiles&parent=program'>Student Profiles</a></li>"+
            "<li><a href='content.html?title=careers&parent=program'>Careers</a></li>"+
        "</ul>";

    }  else if (parent_raw == 'admissions') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='content.html?title=admissions_overview&parent=admissions'>Admissions Overview</a></li>"+
            "<li><a href='content.html?title=admissions_procedures&parent=admissions'>Admissions Procedures</a></li>"+
            "<li><a href='content.html?title=tuition_and_financial_aid&parent=admissions'>Tutition and Financial Aid</a></li>"+
        "</ul>"; 
    } else if (parent_raw == 'students') {
        var page_subnav = "<ul class='side-nav'>\n"+
			"<li><a href='content.html?title=students&parent=students'>Overview</a></li>"+
            "<li><a href='content.html?title=activities&parent=students'>Activities</a></li>"+
			"<li><a href='content.html?title=career_development&parent=students'>Career Development</a></li>"+
			"<li><a href='content.html?title=post-graduate_fellowships&parent=students'>Post-graduate Fellowships</a></li>"+
			"<li><a href='content.html?title=forms&parent=students'>Forms</a></li>"+
			"<li><a href='content.html?title=program_of_studies&parent=students'>Program of Studies</a></li>"+
			"<li><a href='content.html?title=thesis_abstracts&parent=students'>Thesis Abstracts</a></li>"+
			"<li><a href='content.html?title=computing&parent=students'>Computing</a></li>"+
        "</ul>";
        
    } else if (parent_raw == 'faculty_and_research') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='content.html?title=overview&parent=faculty_and_research'>Overview</a></li>"+
            "<li><a href='profiles.html?title=faculty&parent=faculty_and_research'>Faculty</a></li>"+
            "<li><a href='content.html?title=research_areas&parent=faculty_and_research'>Research Areas</a></li>"+
            "<li><a href='content.html?title=visiting_faculty_information&parent=faculty_and_research'>Visiting Faculty Information</a></li>"+
        "</ul>";
        
    } else {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li>"+"<a href='#'>Link one</a></li>\n"+
            "<li>"+"<a href='#'>Link two</a></li>\n"+
            "<li>"+"<a href='#'>Link three</a></li>\n"+ 
            "<li>"+"<a href='#'>Link four</a></li>\n"+
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