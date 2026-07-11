export const videos = [
    {
        id: 'neon-flow',
        creator: 'neon_dancer',
        title: 'Lost in the neon flow tonight',
        category: 'Dance',
        views: '1.2M',
        likes: '124k',
        comments: '1,245',
        image: 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=900&q=80',
        avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=160&q=80',
    },
    {
        id: 'studio-style',
        creator: 'StyleAvant',
        title: 'Structured looks for late-night shoots',
        category: 'Fashion',
        views: '850K',
        likes: '68k',
        comments: '934',
        image: 'https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=900&q=80',
        avatar: 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=160&q=80',
    },
    {
        id: 'club-pulse',
        creator: 'DJ_Vortex',
        title: 'Indigo lasers and midnight bass',
        category: 'Music',
        views: '2.1M',
        likes: '211k',
        comments: '4,808',
        image: 'https://images.unsplash.com/photo-1501386761578-eac5c94b800a?auto=format&fit=crop&w=900&q=80',
        avatar: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=160&q=80',
    },
    {
        id: 'bean-craft',
        creator: 'BeanCrafter',
        title: 'Morning ritual, cinematic pour',
        category: 'Lifestyle',
        views: '420K',
        likes: '39k',
        comments: '620',
        image: 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=900&q=80',
        avatar: 'https://images.unsplash.com/photo-1527980965255-d3b416303d12?auto=format&fit=crop&w=160&q=80',
    },
];

export const conversations = [
    { id: 1, name: 'Maya Chen', handle: '@neon_dancer', unread: 3, preview: 'Can you send the clip timing?', time: '2m', avatar: videos[0].avatar },
    { id: 2, name: 'Leo Marks', handle: '@dj_vortex', unread: 0, preview: 'Tonight works. I added the track.', time: '18m', avatar: videos[2].avatar },
    { id: 3, name: 'Ava Style', handle: '@styleavant', unread: 1, preview: 'Moodboard is ready for review.', time: '1h', avatar: videos[1].avatar },
];

export const contacts = [
    { name: 'Maya Chen', role: 'Creator partner', handle: '@neon_dancer', status: 'Online', avatar: videos[0].avatar },
    { name: 'Ava Style', role: 'Fashion editor', handle: '@styleavant', status: 'Away', avatar: videos[1].avatar },
    { name: 'Leo Marks', role: 'Music producer', handle: '@dj_vortex', status: 'Online', avatar: videos[2].avatar },
    { name: 'Noah Bean', role: 'Lifestyle creator', handle: '@beancrafter', status: 'Offline', avatar: videos[3].avatar },
];
