/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses
*/

// Hover left navigation

$(function() {
	$('#navigation a').stop().animate({'marginLeft':'-85px'},1000);

	$('#navigation > li').hover(
		function () {
			$('a',$(this)).stop().animate({'marginLeft':'-2px'},200);
		},
		function () {
			$('a',$(this)).stop().animate({'marginLeft':'-85px'},200);
		}
	);
});

// Right tab handler

$(document).ready(function() {
                  
                  //Default Action
                  $(".tab_content").hide(); //Hide all content
                  $("ul.tabs li:first").addClass("active").show(); //Activate first tab
                  $(".tab_content:first").show(); //Show first tab content
                  
                  //On Click Event
                  $("ul.tabs li").click(function() {
                                        $("ul.tabs li").removeClass("active"); //Remove any "active" class
                                        $(this).addClass("active"); //Add "active" class to selected tab
                                        $(".tab_content").hide(); //Hide all tab content
                                        var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
                                        $(activeTab).fadeIn(); //Fade in the active content
                                        return false;
                                        });
                  
                  });