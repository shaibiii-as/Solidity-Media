import React, { Component } from 'react';
import * as Constants from "../constants";

const outDivDisplay = {
    display: 'block'
};

class MessagePreview extends Component {
    constructor(props) {
        super(props);
        this.state = {  }
    }
    render() {

        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        let d = new Date();
        let datetime = d.getDate()+' '+months[d.getMonth()]+','+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();

        var messageFile = '';
        if(this.props.fileBase64 !== '')
        {
            switch (this.props.fileType) {
                case "image/jpeg":
                case "image/png":
                    messageFile = <img src={this.props.fileBase64} alt="Message File"></img>;
                    break;
                default:
                    messageFile = <div>
                        <h5>Block Chain File</h5>
                        <div className="row">
                            <div className="col-sm-3">Type:</div>
                            <div className="col-sm-9">{this.props.fileType}</div>
                        </div>
                        <div className="row">
                            <div className="col-sm-3">Size:</div>
                            <div className="col-sm-9">{this.props.msgSize} KB</div>
                        </div>
                        <div className="row">
                            <div className="col-sm-3">Hash:</div>
                            <div className="col-sm-9"></div>
                        </div>
                        <div className="row">
                            <div className="col-sm-3">Link:</div>
                            <div className="col-sm-9"><a href={this.props.fileBase64} target="_blank">Download</a></div>
                        </div>
                    </div>;
                    break;
            }
        }

        return (
            <div className="modal fade" tabIndex="-1" role="dialog" id="previewModal">
                <div className="modal-dialog modal-lg" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <div className="order-boxes-holder">
                                <div className="order-box-outer" style={outDivDisplay}>
                                    <div className="order-top-bar">
                                        <a className="pull-left" href="#" title="Link to This Message">Order #</a>
                                        <img className="pull-left" src={`${Constants.PUBLIC_PREFIX}images/flame.png`} alt="Flame Image" title="This is the title text."></img>
                                        <div className="pull-right">{datetime}</div>
                                    </div>
                                    <div className="order-content-area">
                                        <div className="message-image-holder">
                                            {messageFile}
                                        </div>
                                        <p>{this.props.text}</p>
                                    </div>
                                    <div className="order-bottom-bar">
                                        <ul className="bottom-icons-pack pull-right list-unstyled">
                                            <li><img src={`${Constants.PUBLIC_PREFIX}images/lock.png`} alt="Lock Icon" title="This message is permanently stored on the blockchain"></img></li>
                                            <li><img src={`${Constants.PUBLIC_PREFIX}images/logo.png`} alt="Lock Icon" title="This message was made using our services"></img></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
 
export default MessagePreview;