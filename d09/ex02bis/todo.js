var ft_list;
var cookie = [];

$(document).ready(function(){
    $('#new').click(newTodo);
    $('#ft_list div').click(deleteTodo);
    ft_list = $('#ft_list');
    var tmp = document.cookie;
    if (tmp) {
        cookie = JSON.parse(tmp);
        cookie.forEach(function (e) {
            addTodo(e);
        });
    }
});

$(window).unload(function(){
    var todo = ft_list.children();
    var newCookie = [];
    for (var i = 0; i < todo.length; i++)
        newCookie.unshift(todo[i].innerHTML);
    document.cookie = JSON.stringify(newCookie);
})

function newTodo(){
    var todo = prompt("Que dois-tu faire ?", '');
    if (todo !== '') {
        addTodo(todo)
    }
}

function addTodo(todo){
    ft_list.prepend($('<div>' + todo + '</div>').click(deleteTodo));
}

function deleteTodo(){
    if (confirm("Veux-tu vraiment supprimer cette tâche ?")){
        this.remove();
    }
}