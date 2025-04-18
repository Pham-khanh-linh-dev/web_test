<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>

    <style>
        body {
            margin: 20px;
            font-family: Arial, sans-serif;
        }
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<h2 class="text-center">Lịch Sự Kiện</h2>

<div id="calendar"></div>
<div class="mb-3">
    <h4>Thêm Sự Kiện</h4>
    <form id="addEventForm">
        <div class="mb-2">
            <label for="eventTitle" class="form-label">Tiêu đề:</label>
            <input type="text" id="eventTitle" class="form-control" required>
        </div>
        <div class="mb-2">
            <label for="startDate" class="form-label">Ngày bắt đầu:</label>
            <input type="date" id="startDate" class="form-control" required>
        </div>
        <div class="mb-2">
            <label for="endDate" class="form-label">Ngày kết thúc:</label>
            <input type="date" id="endDate" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', 
        locale: 'vi', 
        events: [
            {
                title: 'Sinh nhật sếp',
                start: '2025-04-02'
            },
            {
                title: 'Họp dự án',
                start: '2025-04-10',
                end: '2025-04-12' 
            }
            
        ]
    });

    
    calendar.render();

    
});
</script>

</body>
</html>