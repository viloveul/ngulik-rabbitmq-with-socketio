let amqp = require('amqp');
let socket = require('socket.io');
let rabbit = amqp.createConnection('amqp://localhost:5672//');
let io = socket(5000, {
	cors: {
		origin: 'http://localhost:6001',
		methods: ['GET', 'POST']
	}
});

rabbit.on('ready', () => {
	console.log('Rabbit connected');
	rabbit.queue('sistem.notifikasi.queue', {autoDelete: false, durable: true}, (queue) => {
		queue.subscribe(message => {
			console.log(message);
			io.emit('notifikasi baru', message);
		});
	})
})