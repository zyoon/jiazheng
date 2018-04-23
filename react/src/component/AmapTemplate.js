import React from 'react'
import {  Input } from 'antd'
import { Map, Markers } from 'react-amap'
import PubSub from 'pubsub-js'
import UIAPILoader from './UIAPILoader'

const style = {
  padding: '8px',
  backgroundColor: '#000',
  color: '#fff',
  border: '1px solid #fff',
};

const mouseoverStyle = {
  padding: '8px',
  backgroundColor: '#fff',
  color: '#000',
  border: '1px solid #000',
}

class AmapTemplate extends React.Component{


    loader: Object;
    positionPicker: Object;
    pubsubHandles: Object;
    polygons: Object;
    district: Object;

    constructor(){
        super()
        this.state={
            amapkey: '5bbb59d21cfd3c409bdf5a2904a308a3',
            show: true,
            text: '显示地图',
            center:{
                longitude: 118.1,
                latitude: 24.46
            },
            map: null,
            geocodes: null,
            markers: []
        }

        this.polygons = [];
        const _this =this
        this.amapEvents = {
            created: (mapInstance) => {
                _this.setState({
                    map: mapInstance
                })
                const AMap = window.AMap   // 初次尝试使用AMap 发现拿不到实例 使用window才能拿到实例对象
                console.log('高德地图 Map 实例创建成功；如果你要亲自对实例进行操作，可以从这里开始。比如：');
                AMap.plugin(['AMap.Autocomplete','AMap.PlaceSearch', 'AMap.Polygon', 'AMap.DistrictSearch'],function(){
                    //行政区划查询
                    var opts = {
                        subdistrict: 1,   //返回下一级行政区
                        showbiz:false  //最后一级返回街道信息
                    };
                    _this.district = new AMap.DistrictSearch(opts);//注意：需要使用插件同步下发功能才能这样直接使用
                    /*
                    const autoOptions = {
                        city: "北京", //城市，默认厦门
                        input: "address_input" //使用联想输入的input的id
                    };
                    const autocomplete= new AMap.Autocomplete(autoOptions);
                    const placeSearch = new AMap.PlaceSearch({
                        city:'北京',
                        map: mapInstance
                    })
                    AMap.event.addListener(autocomplete, "select", function(e){
                        //TODO 针对选中的poi实现自己的功能
                        placeSearch.search(e.poi.name)
                    });
                    */
                });

                _this.showCityInfo();
                //_this.selectCity('福田区', 'district');
                _this.loader = new UIAPILoader(this.state.amapkey).load();

                _this.loadMapUI();
            }
        };
        this.markerEvents = {
            created: (markerInstance) => {
                console.log('高德地图 Marker 实例创建成功；如果你要亲自对实例进行操作，可以从这里开始。比如：');
            }
        }
        //this.markerPosition = { longitude: 118.1, latitude: 24.46 };

        // subscribe only to 'car.drive' topics
        
        const markersOnChange = PubSub.subscribe( 'markers.onchange', this.onSpecificSubscriber.bind(this) );
        const cityOnChange = PubSub.subscribe( 'city.onchange', this.onSpecificSubscriber.bind(this) );
        const positionPickerStart = PubSub.subscribe( 'positionPicker.start', this.onSpecificSubscriber.bind(this) );
        const positionPickerStop = PubSub.subscribe( 'positionPicker.stop', this.onSpecificSubscriber.bind(this) );
        this.pubsubHandles = {markersOnChange: markersOnChange,  cityOnChange: cityOnChange, positionPickerStart: positionPickerStart, positionPickerStop: positionPickerStop};
    }

    componentDidMount() {
    }

    componentWillUnmount() {
        PubSub.unsubscribe( this.pubsubHandles.markersOnChange );
        PubSub.unsubscribe( this.pubsubHandles.cityOnChange );
        PubSub.unsubscribe( this.pubsubHandles.positionPickerStart);
        PubSub.unsubscribe( this.pubsubHandles.positionPickerStart );
    }

    loadMapUI() {
        const self = this;
        this.loader.then(() => {
            const AMapUI = window.AMapUI;
            AMapUI.loadUI(['misc/PositionPicker'], PositionPicker => {
                self.positionPicker = new PositionPicker({
                    mode: 'dragMap',
                    map: self.state.map
                });

                self.positionPicker.on('success', function(positionResult) {
                    PubSub.publish('positionPicker.result', positionResult);
                });
                self.positionPicker.on('fail', function(positionResult) {
                });
                var onModeChange = (e) => {
                    self.positionPicker.setMode(e.target.value)
                }
                PubSub.publish('positionPicker.ready');
            });
        })
        .catch(()=>{
            console.log('asdfasdfsdf');
        });
    }

   randomMarker(len) {
      return Array(len).fill(true).map((e, idx) => ({
        position: {
          longitude: 100 + Math.random() * 20,
          latitude: 30 + Math.random() * 20,
        }
      }))
   }

    onSpecificSubscriber( msg, data ){
        if (msg==='markers.onchange') {
            this.setState({markers: data.markers});
        } else if (msg==='city.onchange') {
            this.selectCity(data.name, data.level);    
        } else if (msg==='positionPicker.start') {
            if (data && data.position) {
                this.positionPicker.start(data.position);
            } else {
                this.positionPicker.start(this.state.map.getBounds().getCenter());
            }
        } else if (msg==='positionPicker.stop') {
            this.positionPicker.stop();
        }
        console.log('specific: ', msg, data );
    }

    showMap(){  // 展示地图
        //const address = this.state.geocodes ? this.state.geocodes[0].formattedAddress : '厦门市莲前街道观日路40号之一二楼'
        //this.searchAddress(address)
        this.setState({
            show: !this.state.show,
            text: !this.state.show ? '隐藏地图' : '显示地图'
        })
        this.showCityInfo();
    }
    handleOnBlurInput(e){ // 输入地址
        const _this = this
        const AMap = window.AMap
        const address = e.target.value
        AMap.plugin(['AMap.Geocoder'],function(){
            /*
            const geocoder = new AMap.Geocoder({
                city:'厦门',
                map: _this.state.map
            })
            geocoder.getLocation(address, function(status, result) {  // 拿到正向地理编码
                if (status === 'complete' && result.info === 'OK') {
                    _this.setState({
                        geocodes:result.geocodes
                    })
                }
            });
            */
        });

        if (this.state.show) {  //  当地图是显示状态时  在此处在调用搜索事件一次
            //this.searchAddress(address)
        }
    }

    showCityInfo() {
        //实例化城市查询类
        const self = this;
        const AMap = window.AMap;

        AMap.plugin(['AMap.CitySearch'], function () {   // 将输入的地理位置进行搜索
            var citysearch = new AMap.CitySearch();
            //自动获取用户IP，返回当前城市
            citysearch.getLocalCity((status, result) => {
                if (status === 'complete' && result.info === 'OK') {
                    if (result && result.city && result.bounds) {
                        var cityinfo = result.city;
                        var citybounds = result.bounds;
                        //document.getElementById('tip').innerHTML = '您当前所在城市：'+cityinfo;
                        //地图显示当前城市
                        self.state.map.setBounds(citybounds);
                    }
                } else {
                    //document.getElementById('tip').innerHTML = result.info;
                }
            });
        });
    }

    selectCity(name, level) {
        const self = this;
        const AMap = window.AMap;
        //清除地图上所有覆盖物
        for (var i = 0, l = this.polygons.length; i < l; i++) {
            this.polygons[i].setMap(null);
        }

        if (!this.district) return;

        this.district.setLevel(level); //行政区级别
        this.district.setExtensions('all');
        //行政区查询
        //按照adcode进行查询可以保证数据返回的唯一性
        this.district.search(name, function(status, result) {
            if(status === 'complete'){
                const data = result.districtList[0];
                const bounds = data.boundaries;
                if (bounds) {
                    for (var i = 0, l = bounds.length; i < l; i++) {
                        var polygon = new AMap.Polygon({
                            map: self.state.map,
                            strokeWeight: 1,
                            strokeColor: '#CC66CC',
                            fillColor: '#CCF3FF',
                            fillOpacity: 0.2,
                            path: bounds[i]
                        });
                        self.polygons.push(polygon);
                    }
                    self.state.map.setFitView();//地图自适应
                }
            }
        });
    }


    searchAddress(address){ // 对地址进行搜索
        const _this = this
        const AMap = window.AMap
        AMap.plugin(['AMap.PlaceSearch'], function () {   // 将输入的地理位置进行搜索
            const placeSearch = new AMap.PlaceSearch({
                city: '厦门',
                map: _this.state.map
            })
            placeSearch.search(address)
            AMap.event.addListener(placeSearch, "complete", function (e) {
                //TODO 完成地图搜索以后,回调函数中可以实现一些自己的功能
                console.log('现在的地址 => ' + address + ' => 完成地图搜索以后,回调函数中可以实现一些自己的功能')
            });

        });
    }

    renderMouseoverLayout(extData){
        return <div style={mouseoverStyle}>{extData.myLabel}</div>
    }

    renderMarkerLayout(extData){
        return <div style={style}>{extData.myLabel}</div>
    }

    renderMarkers(){
       const  markerEvents = {
          mouseover:(e, marker) => {
            marker.render(this.renderMouseoverLayout);
          },
          mouseout: (e, marker) => {
            marker.render(this.renderMarkerLayout);
          }
        }
/*
        const markers = this.randomMarker(100);
        return (<Markers 
            markers={markers}
        />);
*/
        //if (this.state.markers && this.state.markers.length>0) {
            return (<Markers 
                events={markerEvents}
                useCluster={true}
                markers={this.state.markers}
                render={this.renderMarkerLayout}
            />);
        //}
    }
    //center={this.state.center}
                //<Input placeholder="请输入街道名称" id="address_input" onBlur={(e) => this.handleOnBlurInput(e)} onChange={this.props.onChange}/>
    render(){
        return(
            <div className="address-box">
                <div id="map_container" style={{width:600,height:300,marginTop:10,display:'none'}} className={this.state.show ? 'show-map' : 'hidden-map'}>
                    <Map amapkey={'5bbb59d21cfd3c409bdf5a2904a308a3'} events={this.amapEvents} >
                        {this.renderMarkers()}
                    </Map>
                </div>
            </div>
        )
    }
}

export default AmapTemplate
