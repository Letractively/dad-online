/*
DAD Online. Web browser MMORPG.
Copyright(C) 2012 Aceapps Aplicaciones. 
This program is free software: you can redistribute it and/or modify it under 
the terms of the GNU General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later 
version. This program is distributed in the hope that it will be useful, but 
WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more 
details. You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses
*this* source code originaly commited by Sunsoft Servicios.
*/

// function that loads the login form rigth after the html doc is ready
$(document).ready(
function(){
    $("#div1").load("fechable_data.htm #form1")
});

// function that change the login form into the register form, on click
$(document).ready(
function(){
    $("#input4").live("click",
    function(){
        $("#div1").load("fechable_data.htm #form2");
    });
});

//function that change the register form into the login form, on click
$(document).ready(
function(){
    $('#input9').live('click',
    function(){
        $('#div1').load('fechable_data.htm #form1');
    });
});