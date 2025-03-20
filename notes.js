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

// Open the modal
document.getElementById("openSubjectModalBtn").addEventListener("click", function() {
    document.getElementById("subjectModal").style.display = "flex";
});

// Close the subject modal
document.getElementById("cancelSubjectBtn").addEventListener("click", function() {
    document.getElementById("subjectModal").style.display = "none";
});

// Open the note modal
document.getElementById("openNoteModalBtn").addEventListener("click", function() {
    document.getElementById("noteModal").style.display = "flex";
    loadSubjectsIntoDropdown(); // Load subjects
});

// Close the note modal
document.getElementById("cancelNoteBtn").addEventListener("click", function() {
    document.getElementById("noteModal").style.display = "none";
});

document.getElementById("closeNoteView").addEventListener("click", function() {
    document.getElementById("viewNoteModal").style.display = "none";
});

// Save subject
document.getElementById("addSubjectBtn").addEventListener("click", function() {
    let title = document.getElementById("subjectTitle").value;
    let color = document.getElementById("subjectColor").value;

    if (title.trim() === "") {
        alert("Please enter a subject title!");
        return;
    }

    let subjects = JSON.parse(localStorage.getItem("subjects")) || [];
    subjects.push({ title, color });
    localStorage.setItem("subjects", JSON.stringify(subjects));

    let subjectDiv = document.createElement("div");
    subjectDiv.style.background = color;
    subjectDiv.style.padding = "10px";
    subjectDiv.style.margin = "10px 0";
    subjectDiv.style.borderRadius = "5px";
    subjectDiv.innerText = title;

    loadSubjects();
    document.getElementById("subjectModal").style.display = "none";

    document.getElementById("subjectList").appendChild(subjectDiv);

    document.getElementById("subjectModal").style.display = "none";
});

function loadSubjects() {
    let subjects = JSON.parse(localStorage.getItem("subjects")) || [];
    let subjectList = document.getElementById("subjectList");
    subjectList.innerHTML = "";

    subjects.forEach((subject, index) => {
        let subjectDiv = document.createElement("div");
        subjectDiv.style.background = subject.color;
        subjectDiv.style.padding = "10px";
        subjectDiv.style.margin = "10px 0";
        subjectDiv.style.borderRadius = "5px";
        subjectDiv.style.display = "flex";
        subjectDiv.style.justifyContent = "space-between";
        subjectDiv.style.alignItems = "center";

        let subjectText = document.createElement("span");
        subjectText.innerText = subject.title;

        let removeBtn = document.createElement("button");
        removeBtn.innerText = "Remove";
        removeBtn.className = "remove-subject";
        removeBtn.onclick = function () {
            removeSubject(index);
        };

        subjectDiv.appendChild(subjectText);
        subjectDiv.appendChild(removeBtn);
        subjectList.appendChild(subjectDiv);
    });
}

// Function to remove a subject
function removeSubject(index) {
    let subjects = JSON.parse(localStorage.getItem("subjects")) || [];
    subjects.splice(index, 1); // Remove the subject at the given index
    localStorage.setItem("subjects", JSON.stringify(subjects)); // Update localStorage
    loadSubjects(); // Refresh the subject list
}

// Save note
document.getElementById("saveNoteBtn").addEventListener("click", function() {
    let title = document.getElementById("noteTitle").value;
    let subject = document.getElementById("noteSubject").value;
    let content = document.getElementById("noteContent").value;

    let notes = JSON.parse(localStorage.getItem("notes")) || [];
    notes.push({ title, subject, content });
    localStorage.setItem("notes", JSON.stringify(notes));

    loadNotes();
    document.getElementById("noteModal").style.display = "none";

    let li = document.createElement("li");
    li.innerText = title;
    li.onclick = function() {
        document.getElementById("viewNoteTitle").innerText = title;
        document.getElementById("viewNoteSubject").innerText = "Subject: " + subject;
        document.getElementById("viewNoteContent").innerText = content;
        document.getElementById("viewNoteModal").style.display = "flex";
    };

    document.getElementById("uploadedNotes").appendChild(li);
    document.getElementById("noteModal").style.display = "none";
});

function loadNotes() {
    let notes = JSON.parse(localStorage.getItem("notes")) || [];
    let notesList = document.getElementById("uploadedNotes");
    notesList.innerHTML = "";

    notes.forEach((note, index) => {
        let noteDiv = document.createElement("div");
        noteDiv.classList.add("note-item");
        noteDiv.style.display = "flex";
        noteDiv.style.justifyContent = "space-between";
        noteDiv.style.alignItems = "center";
        noteDiv.style.padding = "10px";
        noteDiv.style.border = "1px solid #ccc";
        noteDiv.style.borderRadius = "5px";
        noteDiv.style.marginBottom = "5px";
        noteDiv.style.cursor = "pointer";
        noteDiv.innerHTML = `
            <span onclick="viewNote(${index})">${note.title}</span>
            <button class="remove-note" onclick="removeNote(${index})">Remove</button>
        `;
        notesList.appendChild(noteDiv);
    });
}

function viewNote(index) {
    let notes = JSON.parse(localStorage.getItem("notes")) || [];
    let note = notes[index];

    document.getElementById("viewNoteTitle").textContent = note.title;
    document.getElementById("viewNoteSubject").textContent = "Subject: " + note.subject;
    document.getElementById("viewNoteContent").textContent = note.content;

    document.getElementById("viewNoteModal").style.display = "flex";
}

// Function to remove a note
function removeNote(index) {
    let notes = JSON.parse(localStorage.getItem("notes")) || [];
    notes.splice(index, 1); // Remove the note at the given index
    localStorage.setItem("notes", JSON.stringify(notes)); // Update localStorage
    loadNotes(); // Refresh the notes list
}

function loadSubjectsForNotesDropdown() {
    let subjects = JSON.parse(localStorage.getItem("subjects")) || [];
    let noteSubjectDropdown = document.getElementById("noteSubject");

    if (noteSubjectDropdown.children.length > 1) return;

    subjects.forEach(subject => {
        let option = document.createElement("option");
        option.value = subject.title;
        option.textContent = subject.title;
        noteSubjectDropdown.appendChild(option);
    });
}

// Save subject (Updated)
document.getElementById("addSubjectBtn").addEventListener("click", function () {
    let title = document.getElementById("subjectTitle").value;
    let color = document.getElementById("subjectColor").value;

    if (title.trim() === "") {
        alert("Please enter a subject title!");
        return;
    }

    let subjects = JSON.parse(localStorage.getItem("subjects")) || [];
    subjects.push({ title, color });
    localStorage.setItem("subjects", JSON.stringify(subjects));

    document.getElementById("subjectModal").style.display = "none";
    loadSubjects(); // Refresh the subject list
});

function closeNoteView() {
    document.getElementById("noteViewModal").style.display = "none";
}
document.getElementById("closeNoteView").addEventListener("click", closeNoteView);

// Open & Close Upload File Modal
document.getElementById("openFileUploadModalBtn").addEventListener("click", function() {
    document.getElementById("uploadFileModal").style.display = "flex";
    loadSubjectsIntoFileDropdown();
});

document.getElementById("cancelUploadBtn").addEventListener("click", function() {
    document.getElementById("uploadFileModal").style.display = "none";
});

// Open & Close File Viewer Modal
document.getElementById("closeFileView").addEventListener("click", function() {
    document.getElementById("viewFileModal").style.display = "none";
});

// Save File
document.getElementById("addFileBtn").addEventListener("click", function() {
    let fileInput = document.getElementById("fileUpload");
    let fileSubject = document.getElementById("fileSubject").value;

    if (!fileInput.files.length || !fileSubject) {
        alert("Please select a file and a subject.");
        return;
    }

    let file = fileInput.files[0];
    let fileURL = URL.createObjectURL(file);

    let files = JSON.parse(localStorage.getItem("files")) || [];
    files.push({ name: file.name, subject: fileSubject, url: fileURL });
    localStorage.setItem("files", JSON.stringify(files));

    loadUploadedFiles();
    document.getElementById("uploadFileModal").style.display = "none";
});

// Load Uploaded Files
function loadUploadedFiles() {
    let files = JSON.parse(localStorage.getItem("files")) || [];
    let filesContainer = document.getElementById("uploadedFiles");
    filesContainer.innerHTML = "";

    files.forEach((file, index) => {
        let fileDiv = document.createElement("div");
        fileDiv.innerHTML = `
            <span>${file.name} (${file.subject})</span>
            <button onclick="viewFile('${file.url}', '${file.name}')">View</button>
            <button class="remove-file" onclick="removeFile(${index})">Remove</button>
        `;
        filesContainer.appendChild(fileDiv);
    });
}

// View File
function viewFile(url, name) {
    document.getElementById("viewFileName").textContent = name;
    document.getElementById("fileViewer").src = url;
    document.getElementById("viewFileModal").style.display = "flex";
}

// Remove File
function removeFile(index) {
    let files = JSON.parse(localStorage.getItem("files")) || [];
    files.splice(index, 1);
    localStorage.setItem("files", JSON.stringify(files));
    loadUploadedFiles();
}

// Load Subjects into Dropdown for File Upload
function loadSubjectsIntoFileDropdown() {
    let subjects = JSON.parse(localStorage.getItem("subjects")) || [];
    let fileSubjectDropdown = document.getElementById("fileSubject");
    fileSubjectDropdown.innerHTML = '<option disabled selected>Select a subject</option>';

    subjects.forEach(subject => {
        let option = document.createElement("option");
        option.value = subject.title;
        option.textContent = subject.title;
        fileSubjectDropdown.appendChild(option);
    });
}

// Load Data on Page Load
window.onload = function() {
    loadSubjects();
    loadNotes();
    loadUploadedFiles();
    loadSubjectsIntoFileDropdown();
    loadSubjectsForNotesDropdown();
};
