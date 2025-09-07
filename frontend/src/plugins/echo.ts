import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import { useAuth } from '@/stores/auth';


let echo: Echo<any> |null = null;

export function initEcho(){
  const auth = useAuth();
  if(!auth.token) return null;
  if(echo) return echo;

  (window as any).Pusher = Pusher;
  echo = new Echo({
    broadcaster:'pusher',
    key:import.meta.env.VITE_PUSHER_KEY,
    cluster:import.meta.env.VITE_PUSHER_CLUSTER || 'mt1',
    forceTLS:true,
    authorizer: (channel:any) => ({
      authorize: (socketId:string, callback:Function) => {
        fetch(`${import.meta.env.VITE_API_BASE || ''}/broadcasting/auth`, {
          method:'POST',
          headers:{
            'Content-Type':'application/json',
            'X-Socket-Id':socketId,
            'Authorization': `Bearer ${auth.token}`
          },
          body: JSON.stringify({ channel_name: channel.name })
        }).then(res=>res.json()).then(data=>callback(false,data)).catch(err=>callback(true,err));
      }
    })
  });
  return echo;
}
