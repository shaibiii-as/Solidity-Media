import React, { Component } from 'react';
import * as Constants from "../constants";

class PaymentPopup extends Component {
    constructor(props) {
        super(props);
        this.state = {  }
    }
    render() {

        return (
            <div className="modal" tabIndex="-1" role="dialog" id="paymentModal">
                <div className="modal-dialog modal-lg" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <div className="row">
                                <div className="col-sm-6">
                                    <img className="pull-left" src={`${Constants.PUBLIC_PREFIX}images/metamask.png`} alt="Meta Mask"></img>
                                    <p>MetaMask is not working on your browser. please install MetaMask from below link.</p>
                                    <a className="pull-left" href="https://metamask.io" target="_blank" title="Transaction Details">Brings MetaMask to your browser</a>
                                </div>
                                <div className="col-sm-2"></div>
                                <div className="col-sm-4">
                                    <button data-dismiss="modal" data-toggle="modal" data-target="#otherDepositsModal" type="button" 
                                    className="btn btn-primary btn-lg">Other Deposits</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
 
export default PaymentPopup;