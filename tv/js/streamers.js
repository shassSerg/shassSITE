

class Stream extends React.Component {

  constructor(props) {
    super(props);
        this._isMounted = false;
        this.state = {
          backImg:props.props['back_img'],
          previewUrl: props.props['url_preview']!=null?props.props['url_preview']+ '?' + Math.random():null,
          isLoading: true,
          online: props.props['viewers'],
          login: props.props['login'],
          isError: false,
    };
      //this.isPreview=false;
      //setInterval(this.handleUpdatePreview.bind(this),60000),
      //setInterval(this.handleUpdateOnline.bind(this),60000);
  }

  componentDidMount() {
    this._isMounted = true;
    this.interval1=setInterval(this.handleUpdatePreview.bind(this),60000),
    this.interval2=setInterval(this.handleUpdateOnline.bind(this),60000);
  }
  componentWillUnmount() {
    this._isMounted = false;
    clearInterval(this.interval1);
    clearInterval(this.interval2);
}
  handleUpdatePreview(){
    if (this.state.previewUrl!=null && !this.state.isError)
    this.setState({ previewUrl:this.state.previewUrl+ '?' + Math.random() });
  }
  handleUpdateOnline(){
  try{

  fetch('https://api.shass.ru/live/get_url.php?login='+this.state.login)
  .then(response => {
    if (response.ok) {
        return response.json();
      } else {
          throw new Error('Error query');
        }
      }).then( data =>{
        if (data['status'])
        {
          if (this.state.previewUrl!=data['url_preview']) this.setState({previewUrl:data['url_preview']+ '?' + Math.random(),isError: false });
        }
        else if (this.state.previewUrl!=null) this.setState({ previewUrl:null});
          }
          );
  }catch(e){}

  try{
    fetch('https://api.shass.ru/stats?get=online&login='+this.state.login)
    .then(response => {
        if (response.ok) {
            return response.json();
          } else {
            throw new Error('Error query');
          }
        })
      .then( data =>{if (data['status']) this.setState({ online: data['online']});});
    }catch(e){}
  }
  goToStreamerPage(){
    location.href = "/"+this.props.props['login'];
  }
  handleImageLoaded() {
    if(this._isMounted)
    this.setState({ isLoading: false});
  }
  handleImageError(e) {
    //if(!this.isPreview)
    if(this._isMounted)
    this.setState({ isError: true, isLoading: false });
    //else this.setState({ streamUrl: null });
  }
  render() {
  const {isLoading,online,backImg,previewUrl,isError,login}=this.state;

  //const isPreview_=this.isPreview;
  var realUrl='';
  var er=backImg;
  if (er=='')
  er='images/unload.png';
  //this.isPreview=false;
  if (isError){
    realUrl=er;
  }else{
    if (previewUrl!=null){
        //this.isPreview=true;
        realUrl=previewUrl;
    }else
    realUrl=er;
 }

  if (isLoading){
  var arrayList=[];
  arrayList.push(React.createElement('div', {key:'div-2',className: 'loader-new'},null));
  arrayList.push(React.createElement('img', {key:'img-2',src:realUrl, className:'stream-block-loading', onLoad:this.handleImageLoaded.bind(this),onError:this.handleImageError.bind(this)},null));
  return React.createElement('div', {className:'d-flex justify-content-center stream-block-loading',key:'div-3'},arrayList);
}
  else {
  var arrayList=[];
  arrayList.push(React.createElement('img', {key:'adiv-1', src:realUrl, className:'stream-block-img', onLoad:this.handleImageLoaded.bind(this),onError:this.handleImageError.bind(this)},null));
  arrayList.push(React.createElement('div', {key:'adiv-2', className:'stream-block-info'},null));
  arrayList.push(React.createElement('h1', {key:'adiv1-2', className:'stream-block-info-login'},this.props.props['login']));
  arrayList.push(React.createElement('h1', {key:'adiv2-2', className:'stream-block-info-title'},this.props.props['name_stream']));
  arrayList.push(React.createElement('img', {key:'adiv3-2', src:this.props.props['logo_ava']==''?'/images/none.png':this.props.props['logo_ava'], className:'stream-block-info-logo'},null));
  arrayList.push(React.createElement('h1', {key:'adiv4-2', className:'stream-block-info-online'},(online?online:0)+' online'));
  arrayList.push(React.createElement('h1', {key:'adiv5-2', className:'stream-block-info-online-bool'},previewUrl!=null?'🔴online':'offline'));
  return React.createElement('div', {className:'d-flex justify-content-center stream-block-anim',key:'div-4'},React.createElement('div', {key:'img-1', className:'stream-block',onClick: this.goToStreamerPage.bind(this)},arrayList));
}

  }
}

  var minWidthB=350;

class Streams extends React.Component {

  constructor(props) {
    super(props);
    this._isMounted = false;
    this.state = {
      array: [],
      isLoading: true,
      error: null,
      typeS:Math.floor($(window).width()/minWidthB),
      isEnd: false,
    };

     this.handleWindowSizeChange = this.handleWindowSizeChange.bind(this);
     this.handleScroll = this.handleScroll.bind(this);
     this.DoQuery = this.DoQuery.bind(this);
  }
  componentWillMount() {
    window.addEventListener('resize', this.handleWindowSizeChange);
    window.addEventListener('scroll', this.handleScroll);
  }

  handleScroll() {
    if (this._isMounted && !this.state.isEnd && !this.state.isLoading) {
    if($(window).scrollTop() + screen.height >= $('#app').offset().top+$('#app').outerHeight(true)) {
        this.setState({isLoading: true });
        this.DoQuery();
      }
    }
  }
  DoQuery(){
  const {isEnd,array} = this.state;
    if (!isEnd){
      fetch('https://api.shass.ru/live/get_streamers.php?from='+array.length)
      .then(response => {
          if (response.ok) {
              return response.json();
            } else {
              throw new Error('Error query');
            }
          })
        .then( data =>{
          if (this._isMounted) {
          if (data['status']){
          if (data['result']){
          if (data['result'].length<10)
          this.setState({ array:this.state.array.concat(data['result']), isLoading: false,isEnd:true });
          else {
            this.setState({ array:this.state.array.concat(data['result']), isLoading: false,isEnd:false });
            this.handleScroll();
          }
        }
          else this.setState({ isLoading: false,isEnd:true });
        }
          else throw new Error('Error status');
        }
        }
        )
        .catch(error => this.setState({ error, isLoading: false }));
  }
  }
  componentDidMount() {
    this._isMounted = true;

    this.DoQuery();
    /*fetch('https://api.shass.ru/live/get_streamers.php?from=0')
    .then(response => {
        if (response.ok) {
            return response.json();
          } else {
            throw new Error('Error query');
          }
        })
      .then( data =>{
        if (this._isMounted) {
        if (data['status'])
        this.setState({ array: data['result'], isLoading: false });
        else throw new Error('Error status');
      }
      }
      )
      .catch(error => this.setState({ error, isLoading: false }));*/

  }
  componentWillUnmount() {
  this._isMounted = false;
}
  handleWindowSizeChange() {
    if (this._isMounted) {
      if (Math.floor($(window).width()/minWidthB)!=this.state.typeS)
      this.setState({ typeS: Math.floor($(window).width()/minWidthB) });
    }
    if (this._isMounted && !this.state.isEnd && !this.state.isLoading) {
    if($(window).scrollTop() + screen.height >= $('#app').offset().top+$('#app').outerHeight(true)) {
        this.setState({isLoading: true });
        this.DoQuery();
      }
    }
  }

  componentWillUnmount() {
  window.removeEventListener('resize', this.handleWindowSizeChange);
  window.removeEventListener('scroll', this.handleScroll);
}


  render() {
    const { array, isLoading, error,typeS } = this.state;
    var _typeS=typeS;
    if (_typeS<=0) _typeS=1;

    if (error) {
      return React.createElement('div', null,error.message);
    }

  var result=[];
  var buf;
  do {
  buf=array.slice(result.length*_typeS,result.length*_typeS+_typeS);
  if (buf.length>0){
  if (buf.length-_typeS!=0) buf=buf.concat(new Array(_typeS-buf.length).fill(null));
  result.push(buf);
}
  }while(buf.length>0 && buf);
  buf=null;
  _typeS=null;
  if (isLoading) {
    result.push(new Array(1).fill({load:true}));
    //return React.createElement('div', {className: 'loader'},null);
  }


  const arrayList = result.map(function(row,index){
                  return React.createElement('tr',{key:index,width:'100%'}, row.map(function(stream,index){
                    if (stream){
                      if(stream['load'])
                      return React.createElement('td',{key:index,className:'d-flex justify-content-center stream-block-loading-table' },React.createElement('div', {key:'div-2-main',className: 'loader-new'},null));
                      else return React.createElement('td',{key:index },React.createElement(Stream,{key: stream['login'],props: stream}, null));
                  }
                    else return React.createElement('td',{key:index });}
                  ));
                });
  result=null;
  return React.createElement('table',{key: 'main-table',className: "equal-width-cols"},React.createElement('tbody', { width: '100%', height:'100%',key:'tbody'}, arrayList));

  }
}



//export default App;


function LoadStreamers(){
  $('.loader').addClass('loader-none');
  $('body').append("<div id='ip' class='up'><div id='logo' class='logo-up'></div><div id='box_logo_main' class='logo-box-upper-block-right'><div id='logo_loader' class=\"loader\" style='display: none'></div></div><div id='box_logo_info' class='logo-box-upper-block-right'></div></div><div id='app' class='app-class'></div>");
LogChange();
    LoginBoxR();

  ReactDOM.render(React.createElement(Streams,null), document.getElementById('app'));
}
