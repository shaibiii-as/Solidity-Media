import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Link } from "react-router-dom";
import MessageList from './MessageList';
import MessageWrite from './MessageWrite';
import About from './About';
import Help from './Help';
import '../app.css';
import * as Constants from "../constants";

export default class App extends Component {

  constructor(props) {
    super(props);
    this.state = {
      settings : [],
    };
  }

  componentDidMount = async () => {

    axios.get(Constants.BASE_URL+'/api/settings').then(response => {
      //console.log('site settings',response.data.settings);
      this.setState({settings: response.data.settings});
    });
  }

  render()  {
    return (
      <Router>
        <Header site_title = {this.state.settings.site_title} />
        <div className="container">
          <Route exact path="/" component={MessageList} />
          <Route path="/write" component={MessageWrite} />
          <Route path="/about" component={About} />
          <Route path="/help" component={Help} />
        </div>
      </Router>
    );
  }
}

function Header(props) {
  return (
    <nav className="navbar navbar-default">
      <div className="container-fluid">
        <div className="navbar-header">
          <Link className="navbar-brand" to="/">{props.site_title} <span className="label label-info">Ropsten</span></Link>
        </div>
        <ul className="nav navbar-nav navbar-right">
          <li><Link to="/"><span className="glyphicon glyphicon-home"></span> Home</Link></li>
          <li><Link to="/write"><span className="glyphicon glyphicon-pencil"></span> Write</Link></li>
          <li><Link to="/about"><span className="glyphicon glyphicon-info-sign"></span> About</Link></li>
          <li><Link to="/help"><span className="glyphicon glyphicon-question-sign"></span> Help</Link></li>
        </ul>
      </div>
    </nav>
  );
}

if (document.getElementById('app')) {
  ReactDOM.render(<App />, document.getElementById('app'));
}