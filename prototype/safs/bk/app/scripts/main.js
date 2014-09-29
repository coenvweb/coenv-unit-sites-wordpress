// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
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
var title_raw = getUrlVars()["title"];
var title_page;
var parent_raw = getUrlVars()["parent"];
var parent_page;
var level_raw = getUrlVars()["lvl"];
if (title_raw) {
	var title_page = title_raw.replace(/_/g, ' ');
	var title_page = eachWord(title_page);
}
if (parent_raw) {
    var parent_page = parent_raw.replace(/_/g, ' ');
    var parent_page = eachWord(parent_page);
}


if (parent_raw) {
    if (parent_raw == 'about') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='content.html?title=contact&parent=about'>Contact</a></li>\n"+
            "<li><a href='content.html?title=history&parent=about'>History</a></li>\n"+
            "<li><a href='content.html?title=visitor_info&parent=about'>Visitor info</a></li>\n"+
            "<li><a href='content.html?title=directory&parent=about'>Directory</a></li>\n"+
            "</ul>";

    } else if (parent_raw == 'research') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='content.html?title=major_initiatives&parent=about'>Major Initiatives</a></li>\n"+
            "<li><a href='content.html?title=research_units&parent=research'>Research Units</a></li>\n"+
            "<li><a href='content.html?title=facilities&parent=research'>Facilities</a></li>\n"+
            "<li><a href='content.html?title=resources&parent=research'>Resources</a></li>\n"+
            "<li><a href='content.html?title=recent_publications&parent=research'>Recent Publications</a></li>\n"+
            "</ul>";

    }  else if (parent_raw == 'students' && level_raw == '2') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='content.html?title=undergraduate_program&parent=students&lvl=2'>Undergraduate Program</a></li>\n"+
            "<ul class='lvl-2'>\n"+
                "<li><a href='content.html?title=prospective_students&amp;parent=students&lvl=2'>Prospective Students</a></li>\n"+
                "<li><a href='content.html?title=program_overview&amp;parent=students&lvl=2'>Program Overview</a></li>\n"+
                "<li><a href='content.html?title=program_requirements&amp;parent=students&lvl=2'>Program Requirements</a></li>\n"+
                "<li><a href='content.html?title=research_experience&amp;parent=students&lvl=2'>Research Experience</a></li>\n"+
                "<li><a href='content.html?title=scholarships_and_funding&amp;parent=students&lvl=2'>Scholarships &amp; Funding</a></li>\n"+
                "<li><a href='content.html?title=faq&amp;parent=students&lvl=2'>FAQ</a></li>\n"+
            "</ul>\n</li>\n"+
            "<li><a href='content.html?title=masters_in_marine_science&parent=students'>Masters in Marine Science</a></li>\n"+
            "<li><a href='content.html?title=phd_program&parent=students'>PhD Program</a></li>\n"+
            "<li><a href='content.html?title=meet_current_students&parent=students'>Meet Current Students</a></li>\n"+
            "<li><a href='content.html?title=courses&parent=students'>Courses</a></li>\n"+
            "<li><a href='content.html?title=opportunities_and_resources&parent=students'>Opportunities & Resources</a></li>\n"+
            "<li><a href='content.html?title=careers_and_internships&parent=students'>Careers & Internships</a></li>\n"+
            "<li><a href='content.html?title=contact_an_advisor&parent=students'>Contact an Advisor</a></li>\n"+
            "</ul>"; 
    } else if (parent_raw == 'students') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='content.html?title=undergraduate_program&parent=students&lvl=2'>Undergraduate Program</a></li>\n"+
            "<li><a href='content.html?title=masters_in_marine_science&parent=students'>Masters in Marine Science</a></li>\n"+
            "<li><a href='content.html?title=phd_program&parent=students'>PhD Program</a></li>\n"+
            "<li><a href='content.html?title=meet_current_students&parent=students'>Meet Current Students</a></li>\n"+
            "<li><a href='content.html?title=courses&parent=students'>Courses</a></li>\n"+
            "<li><a href='content.html?title=opportunities_and_resources&parent=students'>Opportunities & Resources</a></li>\n"+
            "<li><a href='content.html?title=careers_and_internships&parent=students'>Careers & Internships</a></li>\n"+
            "<li><a href='content.html?title=contact_an_advisor&parent=students'>Contact an Advisor</a></li>\n"+
            "</ul>";
        
    } else if (parent_raw == 'faculty') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='faculty.html?title=faculty_profiles&parent=faculty'>Faculty Profiles</a></li>\n"+
            "<li><a href='faculty_experts.html?title=find_an_expert&parent=faculty'>Find an Expert</a></li>\n"+
            "</ul>";
        
    } else if (parent_raw == 'alumni_and_community') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='content.html?title=giving&parent=alumni_and_community'>Giving</a></li>\n"+
            "<li><a href='content.html?title=alumni&parent=alumni_and_community'>Alumni</a></li>\n"+
            "<li><a href='content.html?title=stay_connected&parent=alumni_and_community'>Stay Connected</a></li>\n"+
            "<li><a href='content.html?title=outreach&parent=alumni_and_community'>Outreach</a></li>\n"+
            "<li><a href='content.html?title=what_is_this_fish&parent=alumni_and_community'>What is this fish?</a></li>\n"+
            "</ul>";
        
    } else if (parent_raw == 'news_and_events') {
        var page_subnav = "<ul class='side-nav'>\n"+
            "<li><a href='content.html?title=calendar&parent=news_and_events'>Calendar</a></li>\n"+
            "<li><a href='content.html?title=newsletter&parent=news_and_events'>Newsletter</a></li>\n"+
            "<li><a href='content.html?title=seminar_series&parent=news_and_events'>Seminar Series</a></li>\n";
            "<li><a href='content.html?title=student_services_blog&parent=news_and_events'>Student Services Blog</a></li>\n"+
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