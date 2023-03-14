gantt.attachEvent("onAfterTaskUpdate", function(id, item){
    //create an object to store task data
    var taskData = {
        id: item.id,
        text: item.text,
        start_date: item.start_date,
        end_date: item.end_date
    }
    //send data to server using AJAX
    $.ajax({
        type: "POST",
        url: "gantt_data.php",
        data: taskData,
        success: function(response){
            console.log("Task saved!");
        }
    });
});