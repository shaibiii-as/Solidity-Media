const path = require("path");

var HDWalletProvider = require("truffle-hdwallet-provider");

var infura_apikey = "eb3f5c1e237541b696a987a1dbb762f8";
var mnemonic =
  "cluster chunk various exile mixed solar liquid rely license pistol abstract wild";

module.exports = {
  contracts_build_directory: path.join(__dirname, "../resources/js/contracts"),
  networks: {
    development: {
      host: "localhost",
      port: 7545,
      network_id: "*"
    },
    rinkeby: {
      provider: new HDWalletProvider(
        mnemonic,
        "https://rinkeby.infura.io/v3/" + infura_apikey
      ),
      network_id: 4,
      gas: 6000000
    },
    ropsten: {
      provider: new HDWalletProvider(
        mnemonic,
        "https://ropsten.infura.io/v3/" + infura_apikey
      ),
      network_id: 3,
      gas: 6000000
    },
    MainNet: {
      provider: new HDWalletProvider(
        mnemonic,
        "https://mainnet.infura.io/" + infura_apikey
      ),
      network_id: 1,
      gas: 6000000
    }
  },
  compilers: {
    solc: {
      version: "0.7.0",
      parser: "solcjs",
      settings: {
        optimizer: {
          enabled: true
        }
      }
    }
  }
};