const idPasswords = {
    '1160': '01222741403',
    '6680': '01225416886',
    '2700': '01097699815'
};

let pointsData = JSON.parse(localStorage.getItem('pointsData')) || {};
let toggleStates = JSON.parse(localStorage.getItem('toggleStates')) || {};
let currentID = null;
let editingUserID = null;

function checkLogin() {
    const enteredID = document.getElementById('id').value;
    const enteredPassword = document.getElementById('password').value;

    if (idPasswords[enteredID] && idPasswords[enteredID] === enteredPassword) {
        document.getElementById('loginContainer').classList.add('hidden');
        currentID = enteredID;

        if (enteredID === '2700') {
            document.getElementById('adminContainer').classList.remove('hidden');
        } else {
            showBoxes(enteredID);
        }
    } else {
        alert('ID أو كلمة المرور غير صحيحة!');
    }
}

function showBoxesForAdmin() {
    const targetID = document.getElementById('adminTargetID').value;
    if (!targetID || !pointsData[targetID]) {
        alert('هذا ID غير موجود أو لا يحتوي على صناديق.');
        return;
    }

    editingUserID = targetID;
    showBoxes(targetID);
}

function showBoxes(userID) {
    document.getElementById('boxesContainer').classList.remove('hidden');
    const points = (pointsData[userID] || []).length * 4;
    document.getElementById('pointsDisplay').textContent = points;

    const boxesDiv = document.getElementById('boxes');
    boxesDiv.innerHTML = '';

    if (currentID === '2700') {
        document.getElementById('addBoxButton').classList.remove('hidden');
        document.getElementById('saveButton').classList.remove('hidden');
    } else {
        document.getElementById('addBoxButton').classList.add('hidden');
        document.getElementById('saveButton').classList.add('hidden');
    }

    (pointsData[userID] || []).forEach((value, index) => {
        createBox(userID, value, index);
    });
}

function createBox(userID, value = "", index = null) {
    const boxesDiv = document.getElementById('boxes');

    let boxContainer = document.createElement('div');
    boxContainer.classList.add('box-container');

    let input = document.createElement('input');
    input.type = 'text';
    input.value = value;
    input.dataset.index = index !== null ? index : pointsData[userID].length;
    input.dataset.userID = userID;

    if (currentID !== '2700') {
        input.readOnly = true;
    }

    let deleteBtn = document.createElement('button');
    deleteBtn.textContent = '❌';
    deleteBtn.classList.add('delete-btn');
    deleteBtn.onclick = function () {
        deleteBox(userID, input.dataset.index);
    };

    boxContainer.appendChild(input);
    if (currentID === '2700') {
        boxContainer.appendChild(deleteBtn);
    }
    boxesDiv.appendChild(boxContainer);
}

function addBox() {
    if (!editingUserID) return;

    if (!pointsData[editingUserID]) {
        pointsData[editingUserID] = [];
    }

    pointsData[editingUserID].push("");

    showBoxes(editingUserID);
}

function deleteBox(userID, index) {
    if (!pointsData[userID]) return;

    pointsData[userID].splice(index, 1);
    showBoxes(userID);
}

function saveBoxes() {
    if (currentID !== '2700') return;

    const inputs = document.querySelectorAll('#boxes input');

    inputs.forEach(input => {
        let userID = input.dataset.userID;
        let index = input.dataset.index;
        pointsData[userID][index] = input.value;
    });

    localStorage.setItem('pointsData', JSON.stringify(pointsData));
    alert('تم حفظ البيانات بنجاح!');
}