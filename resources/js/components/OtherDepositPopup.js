import React, { Component } from 'react';
import BlockUi from 'react-block-ui';
import 'react-block-ui/style.css';
import * as Constants from "../constants";
import {CopyToClipboard} from 'react-copy-to-clipboard';

var QRCode = require('qrcode.react');

class OtherDepositPopup extends Component {
    constructor(props) {
        super(props);
        this.state = {  
        }
    }

    walletsListing() {
        return this.props.wallets.map(wallet => {
            return (
                <div className="col-sm-6" key={wallet.id}>
                    <h3>{wallet.type} Wallet Address ({wallet.symbol}) {wallet.ticker}</h3>
                    <div className="input-group">
                        <input type="text" className="form-control" value={wallet.address} readOnly></input>
                        <div className="input-group-btn">
                            <CopyToClipboard text={wallet.address} >
                            <button className="btn btn-default"><i className="glyphicon glyphicon-copy"></i></button>
                            </CopyToClipboard>
                        </div>
                    </div>
                    <br></br>
                    <center><QRCode value={wallet.address} /></center>
                </div>
            )
        });
    }

    render() {

        return (
            <div className="modal fade" tabIndex="-1" role="dialog" id="otherDepositsModal">
                <div className="modal-dialog modal-lg" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <BlockUi tag="div" blocking={this.props.otherDepositsPopupBlocking}>
                            {
                                this.props.transactionBtnFlag ?
                                    <form className="Deposit-form" onSubmit={this.props.saveTransactionClickHandler}>
                                        <div className="row">
                                            <div className="col-sm-6">
                                                <label>Deposit Amount</label>
                                                <input type="text" className="form-control" name="deposit_amount" onChange={this.props.transactionFormChangeHandler} required></input>
                                            </div>
                                            <div className="col-sm-6">
                                                <label>Wallet</label>
                                                <select name="wallet_id" className="form-control" onChange={this.props.transactionFormChangeHandler} required>
                                                    <option value="">Select Wallet</option>
                                                    {
                                                        this.props.wallets.map(wallet => {
                                                            return (
                                                                <option value={wallet.id} key={wallet.id}>{wallet.ticker}</option>
                                                            )
                                                        })
                                                    }
                                                </select>
                                            </div>
                                        </div>
                                        <br></br>
                                        <div className="row">
                                            <div className="col-sm-6">
                                                <label>Record Id</label>
                                                <input type="text" placeholder="Record Id" className="form-control" value={this.props.recordId} required readOnly></input>
                                            </div>
                                            <div className="col-sm-6">
                                                <label>Transaction Hash</label>
                                                <input name="transaction_hash" onChange={this.props.transactionFormChangeHandler} type="text" placeholder="Transaction Hash" className="form-control" required></input>
                                            </div>
                                        </div>
                                        <br></br>
                                        <p className="text-danger">{this.props.transactionErrorMessage}</p>
                                        <span className="label label-warning">Steps:</span>
                                        <ul>
                                            <li>Select wallet from dropdown</li>
                                            <li>Enter deposit amount and transaction hash along with record id</li>
                                            <li>Save your transaction for admin approval</li>
                                        </ul>
                                        
                                        <br></br>
                                        <button type="submit" className="btn btn-primary">Save Transaction</button>
                                    </form>
                                :   this.props.transactionSuccessFlag   ?
                                        <div className="alert alert-success" role="alert">
                                            Your transaction is saved successfully!
                                        </div>
                                    :
                                        <div>
                                            <div className="row">
                                                {this.walletsListing()}
                                            </div>
                                            <br></br>
                                            <div className="row">
                                                <div className="col-sm-6">
                                                    <ul>
                                                        <li>Scan BTC wallet address</li>
                                                        <li>Deposit <strong>{this.props.msgCostBtc}</strong> BTC amount</li>
                                                    </ul>
                                                </div>
                                                <div className="col-sm-6">
                                                    <ul>
                                                        <li>Scan ETH wallet address</li>
                                                        <li>Deposit <strong>{this.props.msgCost}</strong> ETH amount</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <br></br>
                                            <button type="button" className="btn btn-primary" onClick={this.props.saveMessageClickHandler}>Save Message</button>
                                        </div>
                            }
                            </BlockUi>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
 
export default OtherDepositPopup;