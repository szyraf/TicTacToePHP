let phase = 0
let side = ''

function ajax(callback, parameters) {
	var xhttp = new XMLHttpRequest()
	xhttp.open('POST', 'server.php', true)

	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			// console.log(side)
			// console.log(this.responseText)
			callback(this.responseText)
		}
	}

	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
	xhttp.send(parameters)
}

function boardClick(id) {
	// console.log(id)
	if (side !== '') {
		sendMove(id)
	}
}

function xSelected() {
	side = 'x'
	phase = 1
	pickSide()
}

function oSelected() {
	side = 'o'
	phase = 1
	pickSide()
}

function pickSide() {
	ajax((res) => {
		let json = JSON.parse(res)
		// console.log(json)
		document.getElementById('wybierzGracza').style.display = 'none'
		document.getElementById('wybrano').innerHTML = `Wybrano: ${side.toUpperCase()}`
		document.getElementById('ruch').innerHTML = 'Twój ruch'
	}, `pickSide=${side}`)
}

function sendMove(id) {
	ajax((res) => {
		let json = JSON.parse(res)
		// console.log(json)

		if ('gameBoard' in json) {
			document.getElementById('ruch').innerHTML = 'Ruch przeciwnika'
			updateGameBoard(json.gameBoard)
		}
	}, `move=${id}&player=${side}`)
}

function updateGameBoard(gameBoard) {
	// console.log(gameBoard)
	gameBoard.forEach((row, i) => {
		row.forEach((cell, j) => {
			if (cell !== '') {
				if (cell === 0) {
					document.getElementById(`${j + i * 3}`).innerHTML = ''
				} else if (cell === 1) {
					document.getElementById(`${j + i * 3}`).innerHTML = 'X'
				} else if (cell === 2) {
					document.getElementById(`${j + i * 3}`).innerHTML = 'O'
				}
			}
		})
	})

	// document.getElementById('').innerHTML =
}

setInterval(() => {
	getData()
}, 100)

function getData() {
	let idkwhoiam = side === '' ? 1 : 0
	ajax((res) => {
		let json = JSON.parse(res)
		// console.log(json)
		// console.log('ok')
		if (idkwhoiam === 1) {
			if ('yourSide' in json) {
				side = json.yourSide
				document.getElementById('wybierzGracza').style.display = 'none'
				document.getElementById('wybrano').innerHTML = `Pozostało Ci: ${side.toUpperCase()}`
				phase = 1
			}
		} else if ('reloadPage' in json) {
			location.reload()
		} else if ('whichTurn' in json) {
			if (json.whichTurn === side) {
				document.getElementById('ruch').innerHTML = 'Twój ruch'
			} else {
				document.getElementById('ruch').innerHTML = 'Ruch przeciwnika'
			}
		}

		if ('winner' in json) {
			document.getElementById('wybierzGracza').style.display = 'none'
			document.getElementById('ruch').style.display = 'none'
			if (json.winner === side) {
				document.getElementById('wygrana').innerHTML = 'Wygrana!'
				document.getElementById('wygrana').style.color = 'green'
			} else if (json.winner === 'draw') {
				document.getElementById('wygrana').innerHTML = 'Remis!'
				document.getElementById('wygrana').style.color = 'orange'
			} else {
				document.getElementById('wygrana').innerHTML = 'Przegrana!'
				document.getElementById('wygrana').style.color = 'red'
			}
		}

		if ('gameBoard' in json) {
			updateGameBoard(json.gameBoard)
		}
	}, `getdata=1&idkwhoiam=${idkwhoiam}`)
}

function reloadServer(id) {
	ajax((res) => {
		let json = JSON.parse(res)
		// console.log(json)
	}, `reload=1`)
}

window.addEventListener('DOMContentLoaded', (event) => {
	reloadServer()
})
