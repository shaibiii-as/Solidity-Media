const MessageStorage = artifacts.require("MessageStorage");

module.exports = function(deployer) {
  deployer.deploy(MessageStorage);
};
