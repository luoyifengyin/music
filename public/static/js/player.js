$(function() {

    // 播放和暂停图标的切换
    // console.log(document.body.clientWidth);
    // $('#play_pause i').click(function(ev) {
    //     if ($('#play_pause i').hasClass('fa-play-circle-o')) {
    //         $(this).removeClass("fa-play-circle-o").addClass("fa-pause-circle-o");
    //     } else {
    //         $(this).removeClass("fa-pause-circle-o").addClass("fa-play-circle-o");
    //     }
    //     return false;
    // });

    //播放音乐/上一首/下一首   

    class Player {
        constructor(node) {
            this.root = typeof node === 'string' ? $(node) : node;
            this.playlist = [];
            this.currentIndex = 0;
            this.audio = new Audio();
            this.button();
            //start();
        }

        //播放音乐
        // start() {
        //     fetch('')
        //         .then(res => res.json())
        //         .then(data => {
        //             console.log(data)
        //             this.playlist = data
        //         })
        // }


        //控制播放
        button() {
            //暂停/继续播放
            let self = this;
            //console.log(this.root)
            this.root.find('#play_pause i').click(function() {
                //alert(self.audio.duration)
                //alert(123)
                if (!self.audio.src){
                    if (self.playlist.length > 0){
                        self.startSong(self.currentIndex);
                    }
                    return;
                }
                //alert(456)
                if (self.audio.paused) {
                    self.play()
                    //   this.querySelector('use').setAttribute('xlink:href','#icon_play')

                } else {
                    self.pause()
                    //  this.querySelector('use').setAttribute('xlink:href','#icon_pause')
                }
            })

            //上一首
            this.root.find('#pre').click(function() {
                self.playPreSong()
            })

            //下一首
            this.root.find('#next').click(function() {
                self.playNextSong()
            })

            //音乐播放的进度条
            this.root.find('.progress_wrap').click(function(e) {
                if (!self.audio.src) return;
                let $pay = $(this).find('#bottom');
                let width = $pay.width();
                // console.log(width);
                //    console.log(e);
                let rate = e.offsetX / width
                let pay_width = Math.round(rate * $pay.attr('max'));
                // console.log(pay_width);
                $pay.val(pay_width);
                self.audio.currentTime = rate * self.audio.duration;
            });


            //音量控制
            this.root.find('#w_bar').click(function(e) {
                // alert($(this).height())

                let volume_bar = Math.round(e.offsetY); //进度条长度
                $('.bar').height(volume_bar);
                //实际音量大小
                let volume = Math.round($(this).height() - e.offsetY) / $(this).height();
                //alert(volume);
                self.audio.volume = volume;
            });

            //音量控制条的显示和隐藏
            this.root.find('.fa-volume-up').click(function() {
                if ($('#volume').hasClass("volume_none")) {
                    $('#volume').removeClass("volume_none");
                    $('#volume').addClass("volume");
                } else if ($('#volume').hasClass("volume")) {
                    $('#volume').removeClass("volume");
                    $('#volume').addClass("volume_none");
                } else {
                    error;
                }
                return false;

            });

            //底部歌单的显示和隐藏
            this.root.find('.fa-list').click(function() {
                if ($('#song_list').hasClass("songlist_none")) {
                    $('#song_list').removeClass("songlist_none");
                    $('#song_list').addClass("songlist");
                } else if ($('#song_list').hasClass("songlist")) {
                    $('#song_list').removeClass("songlist");
                    $('#song_list').addClass('songlist_none');
                }
                // alert(123);
                return false;
            });

            this.root.find('#song_list ul.songlist-item').delegate('li','click',function(){
                let idx = self.root.find('#song_list ul.songlist-item li').index(this);
                self.startSong(idx);
            })

            this.root.find('#song_list ul.songlist-item').delegate('li .song_delete','click',function(){
                let songItems = self.root.find('#song_list ul.songlist-item li')
                let idx = songItems.index($(this).parent(songItems));
                for (var i = idx; i < self.playlist.length - 1; i++) {
                    self.playlist[i] = self.playlist[i+1];
                }
                self.playlist.pop();
                songItems.eq(idx).remove();
                if (self.currentIndex > idx) self.currentIndex--;
                else if (self.currentIndex == idx){
                    self.pause();
                    //self.audio.src = '';
                    self.root.find('.progress_wrap #bottom').val(0);
                    if (self.playlist.length > 0){
                        self.currentIndex--;
                        self.playNextSong();
                    }
                }
                return false;
            })
        }

        play(){
            this.audio.play()
            this.root.find('#play_pause i')
                    .removeClass('fa-play-circle-o')
                    .addClass('fa-pause-circle-o')
        }

        pause(){
            this.audio.pause()
            this.root.find('#play_pause i')
                    .removeClass('fa-pause-circle-o')
                    .addClass('fa-play-circle-o')
        }

        //上一首方法
        playPreSong() {
            // console.log(this.audio)
            // this.currentIndex = (this.playlist.length + this.currentIndex - 1) % this.playlist.length
            // this.audio.src = this.playlist[this.currentIndex].url
            // this.play()
            this.startSong((this.playlist.length + this.currentIndex - 1) % this.playlist.length)
        }

        //下一首方法
        playNextSong() {
            // console.log(this.audio)
            // this.currentIndex = (this.playlist.length + this.currentIndex + 1) % this.playlist.length
            // this.audio.src = this.playlist[this.currentIndex].url
            // this.play()
            this.startSong((this.playlist.length + this.currentIndex + 1) % this.playlist.length)
        }

        startSong(index) {
            if (index >= this.playlist.length) return;
            let song = this.playlist[index]
            if (this.timer) clearInterval(this.timer);
            this.root.find('#song_list ul.songlist-item li').eq(this.currentIndex).removeClass('active')
            this.root.find('#song_list ul.songlist-item li').eq(index).addClass('active')
            this.currentIndex = index;
            this.root.find('#song_name').text(song.name)
            this.root.find('#singer_name').text(song.singer)
            if (song.cover){
                this.root.find('.music_play .icon').html('<div class="bootstrap-iso">'+
                        '<img src="/song/cover/'+song.cover+
                        '" class="img-circle" style="width:50px;height:50px">'+
                    '</div>')
            }
            this.audio.src = this.playlist[index].url;
            //alert(this.audio.src)
            this.play()
            //alert(this.audio.duration)
            this.audio.addEventListener("loadedmetadata", () => {
                this.root.find('.duration').text(this.secondToM_S(this.audio.duration));
                this.timer = setInterval(() => {
                    this.root.find('.current_time').text(this.secondToM_S(this.audio.currentTime))
                    let rate = this.audio.currentTime / this.audio.duration;
                    let progress = this.root.find('#bottom')
                    progress.val(Math.round(rate * progress.attr('max')));
                    if (rate == 1) this.playNextSong();
                }, 1)
            })
        }

        addSong(song, play) {
            this.playlist.push(song);
            let list = this.root.find('ul.songlist-item')
            // alert(list.text())
            // alert(list.html())
            list.html(list.html()+'<li data-play="'+song.id+'">'+
                    '<div class="songlist_songname" title="'+song.name+'">'+song.name+'</div>'+
                    '<div class="songlist_singername" title="'+song.singer+'">'+song.singer+'</div>'+
                    '<div class="songlist_songtime">'+song.duration+'</div>'+
                    '<div class="song_delete"><i class="fa fa-trash-o"></i></div>'+
                '</li>')
            if (play) this.startSong(this.playlist.length-1);
        }

        secondToM_S(sec){
            let h = Math.floor(sec / 3600);
            let m = Math.floor(sec / 60) % 60;
            let s = Math.floor(sec) % 60;
            let timeStr = '';
            if (h) timeStr += h + ':';
            if (m < 10) timeStr += '0';
            timeStr += m + ':';
            if (s < 10) timeStr += '0';
            timeStr += s;
            return timeStr;
        }
    }
    //alert("new");
    player = new Player('#play')


});