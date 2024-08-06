import React, { Component } from 'react';
import MessageStorageContract from "../contracts/MessageStorage.json";
import getWeb3 from "../utils/getWeb3";
import Web3 from "web3";
import ipfs from "../ipfs";
import MessagePreview from './MessagePreview';
import PaymentPopup from './PaymentPopup';
import OtherDepositPopup from './OtherDepositPopup';
import axios from 'axios';
import * as Constants from "../constants";

const buttonStyle = {
    width: '100%'
};

class MessageWrite extends Component {
    constructor(props) {
        super(props);
        this.state = {
            textField                       : 'readOnly',
            text                            : '',
            textSize                        : 0.0,
            fileKey                         : Date.now(),
            fileName                        : '',
            fileType                        : '',
            fileHash                        : '',
            fileBuffer                      : '',
            fileBase64                      : '',
            fileSize                        : 0.0,
            msgSize                         : '0.00000000',
            msgCost                         : '0.00000000',
            msgCostWei                      : 0,
            msgCostBtc                      : 0,
            submittingForm                  : false,
            isbuttonDisable                 : true,
            wallets                         : [],
            settings                        : [],
            transactionBtnFlag              : false,
            recordId                        : '',
            otherDepositsPopupBlocking      : false,
            wallet_id                       : '',
            deposit_amount                  : 0,
            transaction_hash                : '',
            transactionErrorMessage         : '',
            transactionSuccessFlag          : false,
            commission : 0
        };
    }

    componentDidMount = async () => {

        axios.get(Constants.BASE_URL+'/api/wallets').then(response => {
            this.setState({wallets: response.data.wallets});
        });

        axios.get(Constants.BASE_URL+'/api/settings').then(response => {
            //console.log(response.data.settings);
            this.setState({settings: response.data.settings});
        });

        const infuraWeb3 = new Web3(new Web3.providers.HttpProvider(Constants.HTTP_PROVIDER_HOST+'/'+Constants.INFURA_API_KEY));
        this.setState({ infuraWeb3 });

        try {
            // Get network provider and web3 instance.
            const web3 = await getWeb3();
            // Use web3 to get the user's accounts.
            const accounts = await web3.eth.getAccounts();
            // Get the contract instance.
            const networkId = await web3.eth.net.getId();
            const deployedNetwork = MessageStorageContract.networks[networkId];
        
            const instance = new web3.eth.Contract(
                MessageStorageContract.abi,
                deployedNetwork && deployedNetwork.address
            );

            //console.log(instance);
        
            // Set web3, accounts, and contract to the state, and then proceed with an
            // example of interacting with the contract's methods.
            this.setState({ web3, accounts, contract: instance });
        } catch (error) {
            // Catch any errors for any of the above operations.
            // alert(
            //     `Failed to load web3, accounts, or contract. Check console for details.`
            // );
            console.error(error);
        }

        setTimeout(() => {
            this.setState({ textField: ''});
        }, 3000);
    };

    handleSubmit = (event) => {
        event.preventDefault();
        if (!this.state.web3)
        {
            window.$('#paymentModal').modal('show');

            fetch('https://min-api.cryptocompare.com/data/pricemulti?fsyms=ETH&tsyms=ETH,BTC,LTC,DASH')
            .then(response =>  response.json())
            .then(resData => {
               var msgCostBtc = parseFloat(this.state.msgCost * resData.ETH.BTC).toFixed(8);
               this.setState({ msgCostBtc: msgCostBtc });
            });
        }
        else
        {
            this.setState({submittingForm: true,isbuttonDisable: true,textField: 'readOnly'});
            const {accounts,contract,text,fileName,fileType,fileBuffer,msgSize} = this.state;

            var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let d = new Date();
            let datetime = d.getDate()+' '+months[d.getMonth()]+','+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

            this.messageSizeCostCalculation;
            var transactionCommission = this.state.infuraWeb3.utils.fromWei(this.state.commission.toString());
            transactionCommission = this.state.web3.utils.toWei(transactionCommission, "ether");

            if(fileBuffer !== '')
            {
                ipfs.add(fileBuffer).then((result,error) => {
                    if (error) {
                        console.error(error);
                        return;
                    }
    
                    this.setState({fileHash: result[0].hash});
                    // Stores message data on blockchain.
                    contract.methods.addMessage(text,fileName,fileType,result[0].hash,msgSize,datetime).send({ 
                        from: accounts[0], value: transactionCommission
                    }).then((r) => {
                        this.props.history.push('/');
                    });
                });
            }
            else
            {
                // Stores message data on blockchain.
                contract.methods.addMessage(text,fileName,fileType,'',msgSize,datetime).send({ 
                    from: accounts[0], value: transactionCommission
                }).then((r) => {
                    this.props.history.push('/');
                });
            }
        }
    }

    handleChange = (event) => {
        if(event.target.name === 'file'){
            const file = event.target.files[0];
            if(file)
            {
                var fileSize = parseFloat(file.size)/1024;
                // if(fileSize > 500)
                // {
                //     alert(file.name+' exceeds the 500 KB size limit.');
                // }
                // else
                // {
                    this.setState({fileSize: fileSize});
                    this.setState({fileName: file.name});
                    this.setState({fileType: file.type});

                    const reader = new window.FileReader();
                    reader.readAsArrayBuffer(file);
                    reader.onloadend = () => {
                        this.setState({ fileBuffer: Buffer(reader.result) }, () => {
                            //console.log("File buffer", this.state.fileBuffer);
                            reader.readAsDataURL(file);
                            reader.onloadend = () => {
                                this.setState({fileBase64: reader.result},this.messageSizeCostCalculation);
                            };
                        });      
                    };
                //}
            }
            else
            {
                this.setState({msgSize: '0.00000000', fileName: '', fileType: '', fileHash: '', fileBuffer: '', fileBase64: '',fileSize: 0.0},this.messageSizeCostCalculation);
            }
        }
        else
        {
            if(event.target.name === 'text')
            {
                var textSize = parseInt(event.target.value.length)/1024; // convert bytes to kb
                this.setState({textSize: textSize});
            }
            this.setState({[event.target.name] : event.target.value}, this.messageSizeCostCalculation);
        }
    }

    detachFile = () => {
        this.setState({fileKey: Date.now(),fileName: '', fileType: '', fileHash: '', fileBuffer: '', fileBase64: '', fileSize: 0.0},this.messageSizeCostCalculation);
    }

    messageSizeCostCalculation = () => {

        var msgSize = parseFloat(this.state.textSize) + parseFloat(this.state.fileSize);
        if(msgSize > 0)
        {
            // **** Message Cost Calculation *****//
            var kbCost = msgSize * this.state.settings.per_kb_cost;
            var commission = (kbCost * this.state.settings.commission) / 100;
            var msgCostWei = kbCost + commission;
            msgCostWei = msgCostWei.toString();
            
            var msgCost = this.state.infuraWeb3.utils.fromWei(msgCostWei);

            this.setState({msgSize: msgSize.toFixed(8), msgCostWei: msgCostWei, msgCost: parseFloat(msgCost).toFixed(8),commission: msgCostWei});
            if(this.state.textSize > 10)
            {
                alert('Text exceeds the 10 KB size limit.');
                this.setState({isbuttonDisable: true});
            }
            else
            {
                this.setState({isbuttonDisable: false});
            }
        }
        else
        {
            this.setState({msgSize: '0.00000000',msgCost: '0.00000000',isbuttonDisable: true});
        }
    }

    transactionFormChangeHandler = (event) => {
        this.setState({[event.target.name]: event.target.value});
    }

    saveTransactionClickHandler = () => {
        event.preventDefault();

        this.setState({otherDepositsPopupBlocking: true}, () => {
            var transaction = {
                wallet_id        :   this.state.wallet_id,
                record_id        :   this.state.recordId,
                deposit_amount   :   this.state.deposit_amount,
                transaction_hash :   this.state.transaction_hash,
            }

            //console.log(transaction);

            axios.post(Constants.BASE_URL+'/api/transactions', transaction).then(response => {
                //console.log(response);
                if(response.data.message){
                    this.setState({otherDepositsPopupBlocking: false,transactionErrorMessage: response.data.message});
                }
                else{
                    this.setState({otherDepositsPopupBlocking: false, transactionSuccessFlag: true, transactionBtnFlag: false});
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                }
            });
        });
    }

    saveMessageClickHandler = () => {

        this.setState({otherDepositsPopupBlocking: true}, () => {
            var message = {
                text        :   this.state.text,
                size        :   this.state.msgSize,
                cost        :   this.state.msgCost,
                cost_btc    :   this.state.msgCostBtc,
                file_name   :   this.state.fileName,
                file_type   :   this.state.fileType,
                file_hash   :   this.state.fileHash,
            }
    
            if(this.state.fileBuffer !== '')
            {
                ipfs.add(this.state.fileBuffer).then((result,error) => {
                    if (error) {
                        console.error(error);
                        return;
                    }
    
                    this.setState({fileHash: result[0].hash});
                    message.file_hash = result[0].hash;
                    axios.post(Constants.BASE_URL+'/api/messages', message).then(response => {
                        //console.log(response);
                        this.setState({recordId: response.data.id,transactionBtnFlag: true,otherDepositsPopupBlocking: false});
                    });
                });
            }
            else
            {
                axios.post(Constants.BASE_URL+'/api/messages', message).then(response => {
                    //console.log(response);
                    this.setState({recordId: response.data.id,transactionBtnFlag: true,otherDepositsPopupBlocking: false});
                });
            }
        });
    }

    render() {

        let submittingFormLoader = ''; 
        if(this.state.submittingForm)
        {
            submittingFormLoader = <div><p>Please wait...<img height="30px" width="30px" src={`${Constants.PUBLIC_PREFIX}images/loading.gif`} alt="" /></p></div>;
        }

        return (
            <React.Fragment>

                <MessagePreview
                    text={this.state.text}
                    fileBase64={this.state.fileBase64}
                    fileType={this.state.fileType}
                    msgSize={this.state.msgSize}
                ></MessagePreview>
                
                <PaymentPopup></PaymentPopup>

                <OtherDepositPopup
                    wallets = {this.state.wallets}
                    recordId = {this.state.recordId}
                    otherDepositsPopupBlocking = {this.state.otherDepositsPopupBlocking}
                    msgCost = {this.state.msgCost}
                    msgCostBtc = {this.state.msgCostBtc}
                    transactionBtnFlag = {this.state.transactionBtnFlag}
                    transactionErrorMessage = {this.state.transactionErrorMessage}
                    saveTransactionClickHandler = {this.saveTransactionClickHandler}
                    saveMessageClickHandler = {this.saveMessageClickHandler}
                    transactionFormChangeHandler = {this.transactionFormChangeHandler}
                    transactionSuccessFlag = {this.state.transactionSuccessFlag}
                ></OtherDepositPopup>

                <form className="Message-form" onSubmit={this.handleSubmit}>
                    <div className="row">
                        <div className="col-sm-9"> 
                            <div className="panel panel-primary">
                                <div className="panel-heading">New Block Chain Message</div>
                                <div className="panel-body">
                                    <table className="table">
                                        <tbody>
                                            <tr>
                                                <td>Size:</td>
                                                <td>{this.state.msgSize} KB</td>
                                            </tr>
                                            <tr>
                                                <td>Cost:</td>
                                                <td>{this.state.msgCost} ETH</td>
                                            </tr>
                                            <tr>
                                                <td>File:</td>
                                                <td>{this.state.fileName}</td>
                                            </tr>
                                            <tr>
                                                <td>Type:</td>
                                                <td>{this.state.fileType}</td>
                                            </tr>
                                            <tr>
                                                <td>Hash:</td>
                                                <td>{this.state.fileHash}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div className="col-sm-3">
                            <div className="form-group">
                                <input type="file" key={this.state.fileKey} className="form-control" name="file" onChange={this.handleChange}/>
                            </div>
                            <div className="form-group">
                                <button type="button" className="btn btn-default" disabled={!this.state.fileName} onClick={this.detachFile} style={buttonStyle}>DETACH FILE</button>
                                <button type="button" className="btn btn-default" data-toggle="modal" data-target="#previewModal" style={buttonStyle} disabled={this.state.isbuttonDisable}>PREVIEW</button>
                                <input type="submit" className="btn btn-default" value="SAVE TO BLOCK CHAIN" style={buttonStyle} disabled={this.state.isbuttonDisable}/>
                                {submittingFormLoader}
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-sm-9"> 
                            <div className="form-group">
                                <textarea name="text" className="form-control" value={this.state.text} onChange={this.handleChange} placeholder="Type your message here..." readOnly={this.state.textField} rows="10" required/>
                            </div>
                        </div>
                    </div>
                </form>
            </React.Fragment>
        );
    }
}
 
export default MessageWrite;