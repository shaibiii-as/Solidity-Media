import React, { Component } from 'react';
import MessageStorageContract from "../contracts/MessageStorage.json";
import Web3 from "web3";
import * as Constants from "../constants";

const iframeStyle = {
    width: '1000px',
    height: '1000px'
};

class MessageList extends Component {
    constructor(props) {
        super(props);
        this.state = {
            web3: null,
            contract: null,
            messagesCount: 0,
            allMessages: [],
            fetchingData: false,
        };
    }

    componentDidMount = async () => {
        
        try {
            // Get network provider and web3 instance.
            const web3 = new Web3(new Web3.providers.HttpProvider(Constants.HTTP_PROVIDER_HOST+'/'+Constants.INFURA_API_KEY));

            // Get the contract instance.
            const networkId = await web3.eth.net.getId();
            const deployedNetwork = MessageStorageContract.networks[networkId];   
            const instance = new web3.eth.Contract(
                MessageStorageContract.abi,
                deployedNetwork && deployedNetwork.address
            );
        
            // Set web3, accounts, and contract to the state, and then proceed with an
            // example of interacting with the contract's methods.
            this.setState({ web3, contract: instance }, this.fetchStoredDataOnBlockChain);
        } catch (error) {
            // Catch any errors for any of the above operations.
            alert(
                `Failed to load web3, accounts, or contract. Check console for details.`
            );
            console.error(error);
        }
    };
    
    fetchStoredDataOnBlockChain = async () => {
        const { contract } = this.state;
        // Get the value from the contract to prove it worked.
        const response = await contract.methods.getMessageCount().call();
        if(response > 0)
        {
          this.setState({ fetchingData: true });
        }
        // Update state with the result.
        this.setState({ messagesCount: response }, this.fetchMessages);
    };
    
    fetchMessages = async () => {
        let messages = [];
        let thisTarget = this;
        for(let i = this.state.messagesCount-1; i >=0 ; i--)
        {
            this.setState({fetchingData:true}, async () => {
                let message = await this.state.contract.methods.get(i).call();
                messages.push(message);

                let sortedMessages = messages.sort((a, b) => {
                    return b.id - a.id;
                });

                thisTarget.setState({fetchingData:false, allMessages: sortedMessages});
            });
        }
    };

    messageListing() {
        return this.state.allMessages.map(message => {
            var messageFile = "";
            if(message.fileHash !== "")
            {
                var res = message.fileType.split("/");
                switch (res[0]) {
                    case "image":
                        messageFile = <img src={`https://ipfs.io/ipfs/${message.fileHash}`} alt="" />;
                        break;
                    case "video":
                        messageFile =  <video width="500" height="300" controls><source src={`https://ipfs.io/ipfs/${message.fileHash}`} type={message.fileType}></source></video>
                        break;
                    case "audio":
                        messageFile = <audio controls><source src={`https://ipfs.io/ipfs/${message.fileHash}`} type={message.fileType}></source></audio>
                        break;
                    case "application":
                        if(res[1] == 'pdf')
                        {
                            messageFile = <iframe src={`https://ipfs.io/ipfs/${message.fileHash}`} style={iframeStyle}></iframe>
                        }
                        else
                        {
                            messageFile = <div>
                                <h5>Block Chain File</h5>
                                <div className="row">
                                    <div className="col-sm-3">Type:</div>
                                    <div className="col-sm-9">{message.fileType}</div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-3">Size:</div>
                                    <div className="col-sm-9">{message.msgSize} KB</div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-3">Hash:</div>
                                    <div className="col-sm-9">{message.fileHash}</div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-3">Link:</div>
                                    <div className="col-sm-9"><a href={`https://ipfs.io/ipfs/${message.fileHash}`} target="_blank">Download</a></div>
                                </div>
                            </div>;
                        }
                        break;
                    default:
                        messageFile = <div>
                            <h5>Block Chain File</h5>
                            <div className="row">
                                <div className="col-sm-3">Type:</div>
                                <div className="col-sm-9">{message.fileType}</div>
                            </div>
                            <div className="row">
                                <div className="col-sm-3">Size:</div>
                                <div className="col-sm-9">{message.msgSize} KB</div>
                            </div>
                            <div className="row">
                                <div className="col-sm-3">Hash:</div>
                                <div className="col-sm-9">{message.fileHash}</div>
                            </div>
                            <div className="row">
                                <div className="col-sm-3">Link:</div>
                                <div className="col-sm-9"><a href={`https://ipfs.io/ipfs/${message.fileHash}`} target="_blank">Download</a></div>
                            </div>
                        </div>;
                        break;
                }
            }

            return (
                <div className="order-box-outer" key={parseInt(message.id)+1}>
                    <div className="order-top-bar">
                        <span className="pull-left" title="Link to This Message">#{parseInt(message.id)+1}</span>
                        <img className="pull-left" src={`${Constants.PUBLIC_PREFIX}images/flame.png`} alt="Flame Image" title="This is the title text."></img>
                        <div className="pull-right">{message.datetime}</div>
                    </div>
                    <div className="order-content-area">
                        <div className="message-image-holder">
                            {messageFile}
                        </div>
                        <p>{message.text}</p>
                    </div>
                    <div className="order-bottom-bar">
                        <a className="pull-left" href="#" title="Transaction Details">eb0aa7e6bdb9a2243d628ef28fd004270726a3f698d</a>
                        <ul className="bottom-icons-pack pull-right list-unstyled">
                            <li><img src={`${Constants.PUBLIC_PREFIX}images/lock.png`} alt="Lock Icon" title="This message is permanently stored on the blockchain"></img></li>
                            <li><img src={`${Constants.PUBLIC_PREFIX}images/logo.png`} alt="Lock Icon" title="This message was made using our services"></img></li>
                        </ul>
                    </div>
                </div>
            )
        });
    }

    render() {

        if (!this.state.web3) {
            return <div>Loading Web3, accounts, and contract...</div>;
        }
      
        let fetchingDataLoader = ''; 
        if(this.state.fetchingData)
        {
            fetchingDataLoader = (<div className="spinner">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            );
        }
        
        return (
            <div className="messages">
                <div className="order-boxes-holder">
                    {fetchingDataLoader}
                    {this.messageListing()}
                </div>
            </div>
        );
    }
}
 
export default MessageList;