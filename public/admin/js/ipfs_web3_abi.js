// web3 blockchain connection using Infura

if (typeof web3 !== 'undefined') {
    web3 = new Web3(web3.currentProvider);
} else {
    web3 = new Web3(new Web3.providers.HttpProvider('https://ropsten.infura.io/v3/'+infura_api_key));
}

var ABI = [
  {
    "constant": true,
    "inputs": [],
    "name": "msgCount",
    "outputs": [
      {
        "name": "",
        "type": "uint256"
      }
    ],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
  },
  {
    "constant": true,
    "inputs": [
      {
        "name": "",
        "type": "uint256"
      }
    ],
    "name": "message",
    "outputs": [
      {
        "name": "id",
        "type": "uint256"
      },
      {
        "name": "text",
        "type": "string"
      },
      {
        "name": "fileName",
        "type": "string"
      },
      {
        "name": "fileType",
        "type": "string"
      },
      {
        "name": "fileHash",
        "type": "string"
      },
      {
        "name": "msgSize",
        "type": "string"
      },
      {
        "name": "datetime",
        "type": "string"
      }
    ],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
  },
  {
    "constant": false,
    "inputs": [
      {
        "name": "text",
        "type": "string"
      },
      {
        "name": "fileName",
        "type": "string"
      },
      {
        "name": "fileType",
        "type": "string"
      },
      {
        "name": "fileHash",
        "type": "string"
      },
      {
        "name": "msgSize",
        "type": "string"
      },
      {
        "name": "datetime",
        "type": "string"
      }
    ],
    "name": "addMessage",
    "outputs": [],
    "payable": false,
    "stateMutability": "nonpayable",
    "type": "function"
  },
  {
    "constant": false,
    "inputs": [
      {
        "name": "text",
        "type": "string[]"
      },
      {
        "name": "fileName",
        "type": "string[]"
      },
      {
        "name": "fileType",
        "type": "string[]"
      },
      {
        "name": "fileHash",
        "type": "string[]"
      },
      {
        "name": "msgSize",
        "type": "string[]"
      },
      {
        "name": "datetime",
        "type": "string"
      }
    ],
    "name": "addMultipleMessages",
    "outputs": [],
    "payable": false,
    "stateMutability": "nonpayable",
    "type": "function"
  },
  {
    "constant": true,
    "inputs": [],
    "name": "getMessageCount",
    "outputs": [
      {
        "name": "",
        "type": "uint256"
      }
    ],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
  },
  {
    "constant": true,
    "inputs": [
      {
        "name": "index",
        "type": "uint256"
      }
    ],
    "name": "get",
    "outputs": [
      {
        "components": [
          {
            "name": "id",
            "type": "uint256"
          },
          {
            "name": "text",
            "type": "string"
          },
          {
            "name": "fileName",
            "type": "string"
          },
          {
            "name": "fileType",
            "type": "string"
          },
          {
            "name": "fileHash",
            "type": "string"
          },
          {
            "name": "msgSize",
            "type": "string"
          },
          {
            "name": "datetime",
            "type": "string"
          }
        ],
        "name": "",
        "type": "tuple"
      }
    ],
    "payable": false,
    "stateMutability": "view",
    "type": "function"
  }
];

var balanceWei = web3.eth.getBalance(from_address);
var contract = new web3.eth.Contract(ABI, contract_address);