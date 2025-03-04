<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h1, h2 {
            font-size: 24px;
            color: #4CAF50;
            margin-bottom: 10px;
        }
        input, button {
            padding: 10px;
            width: 80%;
            margin: 10px 0;
            border: 2px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .hidden {
            display: none;
        }
        .box-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
            margin-left: 10px;
            padding: 5px;
            border-radius: 4px;
        }
        .toggle-btn {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            margin-left: 10px;
            cursor: pointer;
            border: none;
        }
        .green {
            background-color: green;
        }
        .red {
            background-color: red;
        }
    </style>
</head>
<body>

    <div class="container" id="loginContainer">
        <h1>ACTIVE CODE</h1>
        <h2>أدخل الـ ID وكلمة المرور</h2>
        <input type="text" id="id" placeholder="أدخل الـ ID">
        <input type="password" id="password" placeholder="أدخل كلمة المرور">
        <button onclick="checkLogin()">تحقق</button>
    </div>

    <div class="container hidden" id="adminContainer">
        <h1>إدارة الصناديق</h1>
        <h2>أدخل الـ ID لتعديله</h2>
        <input type="text" id="adminTargetID" placeholder="أدخل ID المستخدم">
        <button onclick="showBoxesForAdmin()">عرض الصناديق</button>
    </div>

    <div class="container hidden" id="boxesContainer">
        <h1>إدارة الصناديق</h1>
        <h2>عدد النقاط المتاحة:</h2>
        <p id="pointsDisplay">0</p>
        <button id="addBoxButton" class="add-btn hidden" onclick="addBox()">+</button>
        <div id="boxes"></div>
        <button id="saveButton" onclick="saveBoxes()">حفظ البيانات</button>
    </div>

    <script>
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

            let toggleBtn = document.createElement('button');
            toggleBtn.classList.add('toggle-btn');

            let toggleKey = `${userID}-${index}`;
            if (toggleStates[toggleKey] === 'red') {
                toggleBtn.classList.add('red');
            } else {
                toggleBtn.classList.add('green');
            }

            toggleBtn.onclick = function () {
                if (toggleBtn.classList.contains('green')) {
                    toggleBtn.classList.remove('green');
                    toggleBtn.classList.add('red');
                    toggleStates[toggleKey] = 'red';
                } else {
                    toggleBtn.classList.remove('red');
                    toggleBtn.classList.add('green');
                    toggleStates[toggleKey] = 'green';
                }
                localStorage.setItem('toggleStates', JSON.stringify(toggleStates));
            };

            let deleteBtn = document.createElement('button');
            deleteBtn.textContent = '❌';
            deleteBtn.classList.add('delete-btn');
            deleteBtn.onclick = function () {
                deleteBox(userID, input.dataset.index);
            };

            boxContainer.appendChild(toggleBtn);
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
    </script>

</body>
</html>
