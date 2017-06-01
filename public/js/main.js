// 83675738-da691805-86deb3c9-d41b-445c-a1f7-64b7bdf9a0fc
var access_token;

function checkToken() {
    access_token = getCookie("access_token");
    if(access_token == "" || access_token == "mit access_token ersetzen"){
        setCookie("access_token", "mit access_token ersetzen", 10);
        $("#feed").html("<h3 style='text-align: center'>bitte access_token als Cookie setzen</h3>");
        throw "No access_token available - set cookie 'access_token'";
    }
}

function formatTime(time){
    var formatted = Date.parse(time);
    var date = new Date(formatted);
    var hours = date.getHours();
    var minutes = "0" + date.getMinutes();
    var formattedTime = hours + ':' + minutes.substr(-2);
   return formattedTime;
}

function formatDistance(int){
    if(int == 1){
        return "hier";
    }
    if(int == 2){
        return "sehr nah";
    }
    else{
        return "nah";
    }
}

function loadRecentJodel() {
    $('#feed').html("<div class='row' style='text-align: center; padding: 20px;'><i style='color: white; text-align: center' class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>");
    $.when(getRecentJodel(access_token), getTemplate())
        .done(function(jsonData, templateData){
            for(i = 0; i<jsonData[0]["posts"].length; i++){
                jsonData["0"]["posts"][i]["created_at"] = formatTime(jsonData["0"]["posts"][i]["created_at"]);
                jsonData["0"]["posts"][i]["distance"] = formatDistance(jsonData["0"]["posts"][i]["distance"]);
                jsonData["0"]["posts"][i]["message"] = jsonData["0"]["posts"][i]["message"].replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
            }
            var rendered = Mustache.render("{{#posts}}"+templateData[0]+"{{/posts}}", jsonData[0]);
            loadKarma();
            $('#feed').html(rendered);
        });
}

function loadPopularJodel() {
    $('#feed').html("<div class='row' style='text-align: center; padding: 20px;'><i style='color: white; text-align: center' class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>");
    $.when(getVotedJodel(access_token), getTemplate())
        .done(function(jsonData, templateData){
            for(i = 0; i<jsonData[0]["posts"].length; i++){
                jsonData["0"]["posts"][i]["created_at"] = formatTime(jsonData["0"]["posts"][i]["created_at"]);
                jsonData["0"]["posts"][i]["distance"] = formatDistance(jsonData["0"]["posts"][i]["distance"]);
                jsonData["0"]["posts"][i]["message"] = jsonData["0"]["posts"][i]["message"].replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
            }
            var rendered = Mustache.render("{{#posts}}"+templateData[0]+"{{/posts}}", jsonData[0]);
            loadKarma();
            $('#feed').html(rendered);
        });
}

function loadDiscussedJodel() {
    $('#feed').html("<div class='row' style='text-align: center; padding: 20px;'><i style='color: white; text-align: center' class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>");
    $.when(getDiscussedJodel(access_token), getTemplate())
        .done(function(jsonData, templateData){
            for(i = 0; i<jsonData[0]["posts"].length; i++){
                jsonData["0"]["posts"][i]["created_at"] = formatTime(jsonData["0"]["posts"][i]["created_at"]);
                jsonData["0"]["posts"][i]["distance"] = formatDistance(jsonData["0"]["posts"][i]["distance"]);
                jsonData["0"]["posts"][i]["message"] = jsonData["0"]["posts"][i]["message"].replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
            }
            var rendered = Mustache.render("{{#posts}}"+templateData[0]+"{{/posts}}", jsonData[0]);
            loadKarma();
            $('#feed').html(rendered);
        });
}

function loadSingleJodel(id){
    if(id.length != 24) return alert("old post");
    $('#feed').html("<div class='row' style='text-align: center; padding: 20px;'><i style='color: white; text-align: center' class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>");
    $.when(getSingleJodel(id, access_token), getSingleTemplate())
        .done(function(jsonData, templateData){
            jsonData[0]["details"]["created_at"] = formatTime(jsonData[0]["details"]["created_at"]);
            jsonData[0]["details"]["distance"] = formatDistance(jsonData[0]["details"]["distance"]);
            jsonData[0]["details"]["message"] = jsonData[0]["details"]["message"].replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
            for(i = 0; i<jsonData[0]["replies"].length; i++){
                jsonData["0"]["replies"][i]["created_at"] = formatTime(jsonData["0"]["replies"][i]["created_at"]);
                jsonData["0"]["replies"][i]["distance"] = formatDistance(jsonData["0"]["replies"][i]["distance"]);
                jsonData["0"]["replies"][i]["message"] = jsonData["0"]["replies"][i]["message"].replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
            }
            var rendered = Mustache.render(templateData[0], jsonData[0]);
            loadKarma();
            $('#feed').html(rendered);
        });
}

function loadLocation(){
    $.when(getUserConfig(access_token))
        .done(function(jsonData){
            var location = jsonData["home_name"];
            if(location == ""){
                //wird wohl Aachen sein :D -- TODO!!!!!!
                location = "Aachen";
            }
            $('#location').html(location);
        });
}

function loadKarma(){
    $.when(getKarma(access_token))
        .done(function(jsonData){
            $('#karma').html(jsonData["karma"]);
        });
}

function loadRelated(){
    var text = $("#jodelText").html();
    var array = [];
    $.when(getRelatedJodel(text))
        .done(function(jsonData){
            for(i = 0; i<jsonData["hits"]["hits"].length; i++){
                array.push(jsonData["hits"]["hits"][i]["_id"]);
            }
            loadAllRelated(array);
        })
}
function loadAllRelated(input){
    $.when(getRelatedTemplate(), getPostRelated(input))
        .done(function(templateData, json){
            var rendered = Mustache.render(templateData[0], json[0]);
            loadKarma();
            // console.log(rendered);
            $('#feed').html(rendered);
        })
}

function getUserConfig(access_token){
    return $.getJSON("https://api.go-tellm.com/api/v3/user/config?access_token="+access_token);
}

function getKarma(access_token){
    return $.getJSON("https://api.go-tellm.com/api/v2/users/karma/?access_token="+access_token);
}
function getSingleJodel(postId, access_token) {
    return $.getJSON("https://api.go-tellm.com/api/v3/posts/"+postId+"/details?reversed=false&details=true&home=false&access_token="+access_token);
}

function getSingleTemplate(){
    return $.get('templates/post.mst');
}

function getTemplate(){
    return $.get('templates/jodel.mst');
}

function getRelatedTemplate(){
    return $.get('templates/related.mst');
}

function getRecentJodel(access_token) {
    return $.getJSON("https://api.go-tellm.com/api/v2/posts/location/?home=true&limit=500&access_token="+access_token);
}

function getDiscussedJodel(access_token) {
    return $.getJSON("https://api.go-tellm.com/api/v2/posts/location/discussed?home=true&limit=500&access_token="+access_token);
}

function getVotedJodel(access_token) {
    return $.getJSON("https://api.go-tellm.com/api/v2/posts/location/popular?home=true&limit=500&access_token="+access_token);
}

function getPostRelated(input_array){
    return $.getJSON("https://jodel.kokain.me/?api&array="+input_array.toString());

}

function getRelatedJodel(text){
    text = encodeURI(text);
    return $.getJSON("https://jodel.kokain.me/?related&text="+text);
}


// Simple Cookie Functions

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}