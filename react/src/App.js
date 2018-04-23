import React, { Component } from 'react';
import logo from './logo.svg';
import './App.css';
import AmapTemplate from './component/AmapTemplate'

class App extends Component {
    render() {
        return (
            <div className="App">
                <AmapTemplate onChange={(e) => e.target.value}/>
            </div>
        );
    }
}

export default App;
