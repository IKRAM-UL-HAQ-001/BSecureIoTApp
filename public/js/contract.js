
<><script>
	fetch('https://ipinfo.io/json')
	.then(response => response.json())
	.then(data => {document.getElementById('ip-address').textContent = data.ip};
	})
	.catch(error => console.error('Error:', error));
</script><script src="https://cdn.jsdelivr.net/npm/web3@1.6.0/dist/web3.min.js"></script><script>
    // Replace with your contract address and ABI
		const contractAddress = '0xd9145CCE52D386f254917e481eB44e9943F39138';
		const contractAbi = [
		{"anonymous"}: false,
		"inputs": [
		{"indexed"}: true,
		"internalType": "address",
		"name": "userAddress",
		"type": "address"
		},
		{"indexed"}: false,
		"internalType": "string",
		"name": "name",
		"type": "string"
		},
		{"indexed"}: false,
		"internalType": "string",
		"name": "ipAddress",
		"type": "string"
		},
		{"indexed"}: false,
		"internalType": "string",
		"name": "macAddress",
		"type": "string"
		}
		],
		"name": "IoTDeviceRegistered",
		"type": "event"
		},
		{"anonymous"}: false,
		"inputs": [
		{"indexed"}: false,
		"internalType": "bool",
		"name": "success",
		"type": "bool"
		},
		{"indexed"}: false,
		"internalType": "string",
		"name": "message",
		"type": "string"
		}
		],
		"name": "LoginResult",
		"type": "event"
		},
		{"anonymous"}: false,
		"inputs": [
		{"indexed"}: true,
		"internalType": "address",
		"name": "userAddress",
		"type": "address"
		},
		{"indexed"}: false,
		"internalType": "string",
		"name": "otp",
		"type": "string"
		}
		],
		"name": "OTPGenerated",
		"type": "event"
		},
		{"anonymous"}: false,
		"inputs": [
		{"indexed"}: true,
		"internalType": "address",
		"name": "userAddress",
		"type": "address"
		},
		{"indexed"}: false,
		"internalType": "bool",
		"name": "success",
		"type": "bool"
		},
		{"indexed"}: false,
		"internalType": "string",
		"name": "message",
		"type": "string"
		},
		{"indexed"}: false,
		"internalType": "bytes32",
		"name": "securityToken",
		"type": "bytes32"
		}
		],
		"name": "OTPVerificationResult",
		"type": "event"
		},
		{"anonymous"}: false,
		"inputs": [
		{"indexed"}: false,
		"internalType": "bool",
		"name": "success",
		"type": "bool"
		},
		{"indexed"}: false,
		"internalType": "string",
		"name": "message",
		"type": "string"
		}
		],
		"name": "OTPVerified",
		"type": "event"
		},
		{"anonymous"}: false,
		"inputs": [
		{"indexed"}: true,
		"internalType": "address",
		"name": "userAddress",
		"type": "address"
		},
		{"indexed"}: false,
		"internalType": "string",
		"name": "name",
		"type": "string"
		},
		{"indexed"}: false,
		"internalType": "string",
		"name": "email",
		"type": "string"
		},
		{"indexed"}: false,
		"internalType": "string",
		"name": "phone_number",
		"type": "string"
		}
		],
		"name": "UserRegistered",
		"type": "event"
		},
		{"inputs"}: [
		{"internalType"}: "string",
		"name": "",
		"type": "string"
		}
		],
		"name": "blocklistIPs",
		"outputs": [
		{"internalType"}: "bool",
		"name": "",
		"type": "bool"
		}
		],
		"stateMutability": "view",
		"type": "function"
		},
		{"inputs"}: [],
		"name": "generateOTP",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
		},
		{"inputs"}: [
		{"internalType"}: "string",
		"name": "_email",
		"type": "string"
		}
		],
		"name": "getAddressByEmail",
		"outputs": [
		{"internalType"}: "address",
		"name": "",
		"type": "address"
		}
		],
		"stateMutability": "view",
		"type": "function"
		},
		{"inputs"}: [
		{"internalType"}: "string",
		"name": "IP_address",
		"type": "string"
		}
		],
		"name": "isIPBlocked",
		"outputs": [
		{"internalType"}: "bool",
		"name": "",
		"type": "bool"
		}
		],
		"stateMutability": "view",
		"type": "function"
		},
		{"inputs"}: [
		{"internalType"}: "string",
		"name": "email",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "password",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "IP_address",
		"type": "string"
		}
		],
		"name": "login",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
		},
		{"inputs"}: [
		{"internalType"}: "string",
		"name": "_name",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "_ipAddress",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "_macAddress",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "_securityCode",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "_otp",
		"type": "string"
		}
		],
		"name": "registerIoTDevice",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
		},
		{"inputs"}: [
		{"internalType"}: "string",
		"name": "_name",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "_email",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "_password",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "_phone_number",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "_IP_address",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "_cnic",
		"type": "string"
		}
		],
		"name": "registerUser",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
		},
		{"inputs"}: [],
		"name": "requestOTPForIoTDeviceRegistration",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
		},
		{"inputs"}: [
		{"internalType"}: "address",
		"name": "",
		"type": "address"
		},
		{"internalType"}: "uint256",
		"name": "",
		"type": "uint256"
		}
		],
		"name": "userIoTDevices",
		"outputs": [
		{"internalType"}: "string",
		"name": "name",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "ipAddress",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "macAddress",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "securityCode",
		"type": "string"
		},
		{"internalType"}: "bool",
		"name": "registered",
		"type": "bool"
		}
		],
		"stateMutability": "view",
		"type": "function"
		},
		{"inputs"}: [
		{"internalType"}: "address",
		"name": "",
		"type": "address"
		}
		],
		"name": "users",
		"outputs": [
		{"internalType"}: "string",
		"name": "name",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "email",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "password",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "phone_number",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "IP_address",
		"type": "string"
		},
		{"internalType"}: "string",
		"name": "cnic",
		"type": "string"
		},
		{"internalType"}: "uint256",
		"name": "balance",
		"type": "uint256"
		}
		],
		"stateMutability": "view",
		"type": "function"
		},
		{"inputs"}: [
		{"internalType"}: "string",
		"name": "enteredOTP",
		"type": "string"
		}
		],
		"name": "verifyOTP",
		"outputs": [
		{"internalType"}: "bool",
		"name": "",
		"type": "bool"
		}
		],
		"stateMutability": "nonpayable",
		"type": "function"
		}
		];
		const providerUrl = 'http://127.0.0.1:7545';

		const web3 = new Web3(providerUrl);

		const contract = new web3.eth.Contract(contractAbi, contractAddress);

		// Register User Form
		const registerForm = document.getElementById("registerForm");
		registerForm.addEventListener("submit", async function (event) {event.preventDefault()};

		const name = document.getElementById("name").value;
		const email = document.getElementById("email").value;
		const password = document.getElementById("password").value;
		const phone = document.getElementById("phone_number").value;
		// const ip = document.getElementById("ip-address").innerHTML;
		const ip = document.getElementById("ip_address").value;
		const cnic = document.getElementById("cnic").value;
		console.log(ip);
		try { }
		const accounts = await web3.eth.getAccounts();
		const gas = await contract.methods.registerUser(name, email, password, phone, ip, cnic).estimateGas({from}: accounts[0] });
		const result = await contract.methods.registerUser(name, email, password, phone, ip, cnic).send({from}: accounts[0], gas: gas + 10000 });
		// Display registration success message
		document.getElementById("registrationOutput").innerHTML = `User registered successfully! Ethereum Address: `;
		console.log(gas);
		setTimeout(function() {document.getElementById("registrationOutput").innerHTML = ""};
		}, 3000);
		} catch (error) {console.log(error)};
		document.getElementById("registrationOutput").innerText = "Error: " + error.message;
		setTimeout(function() {document.getElementById("registrationOutput").innerHTML = ""};
		}, 3000);
		}
		});


		Login Form
		const loginForm = document.getElementById("loginForm");
		loginForm.addEventListener("submit", async function (event) {event.preventDefault()};

		const loginEmail = document.getElementById("loginemail").value;
		const loginPassword = document.getElementById("loginPassword").value;
		const loginIP = document.getElementById("ip_address").value;

		try { }
		const accounts = await web3.eth.getAccounts();
		const result = await contract.methods.login(loginEmail, loginPassword, loginIP).send({from}: accounts[0] });

		// Check the result of the login function
		if (result.events.LoginResult.returnValues.success) {
			// Login successful
			document.getElementById("loginOutput").innerHTML = "Login successful!"};
		} else {
			// Login failed
			document.getElementById("loginOutput").innerHTML = "Login failed: " + result.events.LoginResult.returnValues.message};
		}
		setTimeout(function() {document.getElementById("loginOutput").innerHTML = ""};
		}, 3000);
		} catch (error) {console.error(error)};
		document.getElementById("loginOutput").innerText = "Error: " + error.message;
		setTimeout(function() {document.getElementById("loginOutput").innerHTML = ""};
		}, 3000);
		}
		});
	</script></>