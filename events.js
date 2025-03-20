document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.querySelector(".menu-icon");
    const sidebar = document.querySelector(".sidebar");
    const productivityTools = document.getElementById("productivityTools");
    const dropdownMenu = document.querySelector(".dropdown-menu");

    menuIcon.addEventListener("click", function () {
        sidebar.classList.toggle("expanded"); // Expands sidebar
        sidebar.classList.toggle("hidden"); // Toggles transparency
    });

    // Toggle Productivity Tools Dropdown
    productivityTools.addEventListener("click", function (event) {
        event.preventDefault(); 
        dropdownMenu.classList.toggle("show");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Select calendar elements
    const currentMonthEl = document.getElementById("currentMonth");
    const calendarDaysEl = document.getElementById("calendarDays");
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");
    const addEventBtn = document.getElementById("addEventBtn");
    const upcomingEventsEl = document.getElementById("upcomingEvents");

    // Select modal elements
    const eventModal = document.getElementById("eventModal");
    const modalHeader = document.getElementById("modalHeader");
    const eventNameInput = document.getElementById("eventName");
    const eventDateInput = document.getElementById("eventDate");
    const eventTypeInput = document.getElementById("eventType");
    const eventStartTimeInput = document.getElementById("eventStartTime");
    const eventEndTimeInput = document.getElementById("eventEndTime");
    const eventLocationInput = document.getElementById("eventLocation");
    const eventAvailabilityInput = document.getElementById("eventAvailability");
    const saveEventBtn = document.getElementById("saveEventBtn");
    const closeModalBtn = document.getElementById("closeModal");

    if (!eventModal || !closeModalBtn) {
        console.error("Modal elements missing! Check HTML.");
        return;
    }

    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    let events = JSON.parse(localStorage.getItem("events")) || [];

    function updateCalendar() {
        calendarDaysEl.innerHTML = "";
        currentMonthEl.textContent = new Date(currentYear, currentMonth).toLocaleString("en-US", { month: "long", year: "numeric" });

        let firstDay = new Date(currentYear, currentMonth, 1).getDay();
        let lastDate = new Date(currentYear, currentMonth + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            let emptyCell = document.createElement("div");
            emptyCell.classList.add("empty");
            calendarDaysEl.appendChild(emptyCell);
        }

        for (let day = 1; day <= lastDate; day++) {
            let dayCell = document.createElement("div");
            dayCell.textContent = day;
            dayCell.classList.add("day");

            let formattedDate = `${currentYear}-${String(currentMonth + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
            let eventOnDate = events.find(event => event.date === formattedDate);
            if (eventOnDate) {
                dayCell.style.backgroundColor = getEventColor(eventOnDate.type);
                dayCell.style.color = "#fff";
            }

            calendarDaysEl.appendChild(dayCell);
        }
    }

    function updateUpcomingEvents() {
        upcomingEventsEl.innerHTML = "";

        if (!Array.isArray(events)) {
            console.warn("⚠️ 'events' is not an array. Resetting storage.");
            events = [];
            localStorage.setItem("events", JSON.stringify(events));
        }

        if (events.length === 0) {
            upcomingEventsEl.innerHTML = "<li>No upcoming events</li>";
            return;
        }

        events.forEach((event, index) => {
            let eventItem = document.createElement("li");
            eventItem.textContent = `${event.name} (${event.date})`;
            eventItem.style.color = getEventColor(event.type);
            eventItem.addEventListener("click", () => openEventModal(event, index));
            upcomingEventsEl.appendChild(eventItem);
        });

        localStorage.setItem("events", JSON.stringify(events));
    }

    function getEventColor(type) {
        const colors = {
            "School Event": "pink",
            "Quiz/Exam": "red",
            "Activities/Projects": "yellow"
        };
        return colors[type] || "gray";
    }

    function openEventModal(event = null, index = null) {
        modalHeader.textContent = event ? "Edit Event" : "Add an Event";

        if (event) {
            eventNameInput.value = event.name;
            eventDateInput.value = event.date;
            eventTypeInput.value = event.type;
            eventStartTimeInput.value = event.startTime;
            eventEndTimeInput.value = event.endTime;
            eventLocationInput.value = event.location;
            eventAvailabilityInput.value = event.availability;
            saveEventBtn.dataset.index = index;
        } else {
            eventNameInput.value = "";
            eventDateInput.value = "";
            eventTypeInput.value = "School Event";
            eventStartTimeInput.value = "";
            eventEndTimeInput.value = "";
            eventLocationInput.value = "";
            eventAvailabilityInput.value = "Public";
            delete saveEventBtn.dataset.index;
        }

        eventModal.style.display = "block";
    }

    function saveEvent() {
        let eventData = {
            name: eventNameInput.value.trim(),
            date: eventDateInput.value.trim(),
            type: eventTypeInput.value.trim(),
            startTime: eventStartTimeInput.value.trim(),
            endTime: eventEndTimeInput.value.trim(),
            location: eventLocationInput.value.trim(),
            availability: eventAvailabilityInput.value.trim()
        };

        if (!eventData.name || !eventData.date) {
            alert("Please fill in the required fields.");
            return;
        }

        if (saveEventBtn.dataset.index !== undefined) {
            events[saveEventBtn.dataset.index] = eventData;
        } else {
            events.push(eventData);
        }

        localStorage.setItem("events", JSON.stringify(events));
        updateCalendar();
        updateUpcomingEvents();
        closeModal();
    }

    function closeModal() {
        eventModal.style.display = "none";
    }

    prevMonthBtn.addEventListener("click", function () {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateCalendar();
    });

    nextMonthBtn.addEventListener("click", function () {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendar();
    });

    addEventBtn.addEventListener("click", () => openEventModal());
    saveEventBtn.addEventListener("click", saveEvent);
    closeModalBtn.addEventListener("click", closeModal);

    // ✅ Close modal when clicking outside
    window.addEventListener("click", function (event) {
        if (event.target === eventModal) {
            closeModal();
        }
    });

    updateCalendar();
    updateUpcomingEvents();
});






