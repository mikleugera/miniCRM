<?php 
    $title = 'Home page';
    ob_start(); 
?>
    
    <h1>Home page</h1> 

    <div id='calendar'></div>
    <?php $path = '/todo/tasks/task/'?>

<script>
    //получение данних о задачах, из нашего PHP-контролера
    const tasksJson = <?= json_encode($tasksJson)?>;
    const tasks = JSON.parse(tasksJson); //tasks масив обєктов 
    //преобразование даних (масива) в задачи для календаря 
    const events = tasks.map((task) => {
        return {
            title: task.title,
            start: new Date(task.created_at),
            end: new Date(task.finish_date),
            extendedProps: {
                task_id: task.id
            },
        };
    }) 
    //обрабочик собитий загрузки DOM 
    document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: events,
        eventClick: function(info){
            const taskId = info.event.extendedProps.task_id;
            //URL для адреса страници конкретной задачи
            const taskURL = `<?= $path?>${taskId}`;  
            //переход на страницу задачи
            window.location.href = taskURL;
        },
    });
    calendar.render();
    });

</script>    
<?php 
$content = ob_get_clean();
include 'app/views/layout.php';
?>      


