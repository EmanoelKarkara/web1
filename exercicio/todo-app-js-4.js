// by Franklyn https://codepen.io/franklynroth/pen/ZYeaBd
var atividade=document.getElementById("atividade");//Add a new task.
var responsavel=document.getElementById("responsavel");//Add a new task.
var prazo=document.getElementById("prazo");//Add a new task.
var addButton=document.getElementsByTagName("button")[0];//first button
var incompleteTaskHolder=document.getElementById("incomplete-tasks");//ul of #incomplete-tasks
var completedTasksHolder=document.getElementById("completed-tasks");//completed-tasks


//New task list item
var createNewTaskElement=function(atv, rspv, prz){

	var listItem=document.createElement("tr");

	var labelAtividade=document.createElement("td");
	var labelResponsavel=document.createElement("td");
	var labelPrazo=document.createElement("td");
	
	var editButton=document.createElement("button");
	var deleteButton=document.createElement("button");	
	var fazerButton=document.createElement("button");
	editButton.className="edit";
	deleteButton.className="delete";


	labelAtividade.innerText=atv;
	labelResponsavel.innerText=rspv;
	labelPrazo.innerText=prz;

	editButton.innerText="Editar";//innerText encodes special characters, HTML does not.
	deleteButton.innerText="Remover";
	fazerButton.innerText="Fazer";

	//and appending.
	listItem.appendChild(labelAtividade);
	listItem.appendChild(labelResponsavel);
	listItem.appendChild(labelPrazo);
	listItem.appendChild(editButton);
	listItem.appendChild(deleteButton);
	listItem.appendChild(fazerButton);

	return listItem;
}

var addTask=function(){
	console.log("Add Task...");
	
	if(atividade.value.trim() != "" && responsavel.value.trim() != "" && prazo.value.trim() != ""){
		//Create a new list item with the text from the #new-task:
		var listItem=createNewTaskElement(atividade.value, responsavel.value, prazo.value);
		
		//Append listItem to incompleteTaskHolder
		incompleteTaskHolder.appendChild(listItem);
		bindTaskEvents(listItem, taskCompleted);
		atividade.value="";
		responsavel.value="";
		prazo.value="";
	}else{
		alert("Campo vazio!");
	}

}

//Edit an existing task.
var editTask=function(){
	console.log("Edit Task...");
	var listItem=this.parentNode;
	
	var element = listItem.querySelector("label");
	atividade.value = element.innerText;
}

//Delete task.
var deleteTask=function(){
		console.log("Delete Task...");

		var listItem=this.parentNode;
		var ul=listItem.parentNode;
		//Remove the parent list item from the ul.
		ul.removeChild(listItem);

}

var feito = false;

var taskIncomplete=function(){
	console.log("Incomplete Task...");
	var listItem=this.parentNode;

		
	if(feito){
		incompleteTaskHolder.appendChild(listItem);
		bindTaskEvents(listItem,taskCompleted);
	}else{
		feito=true
		incompleteTaskHolder.appendChild(listItem);
		bindTaskEvents(listItem,taskCompleted);
	}
	
}

//Set the click handler to the addTask function.
//addButton.onclick=addTask;
addButton.addEventListener("click",addTask);

var bindTaskEvents=function(taskListItem){
	console.log("bind list item events");
//select ListItems children
	var editButton=taskListItem.querySelector("button.edit");
	var deleteButton=taskListItem.querySelector("button.delete");
	var fazerButton=taskListItem.querySelector("button.delete");
	
			editButton.onclick=editTask;
			deleteButton.onclick=deleteTask;
			fazerButton.onclick=deleteTask;
}

//cycle over incompleteTaskHolder ul list items
	//for each list item
	for (var i=0; i<incompleteTaskHolder.children.length;i++){

		//bind events to list items chldren(tasksCompleted)
		bindTaskEvents(incompleteTaskHolder.children[i],taskCompleted);
	}

//cycle over completedTasksHolder ul list items
	for (var i=0; i<completedTasksHolder.children.length;i++){
	//bind events to list items chldren(tasksIncompleted)
		bindTaskEvents(completedTasksHolder.children[i],taskIncomplete);
	}

