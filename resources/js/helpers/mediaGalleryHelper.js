/**
 * Unified Media Gallery & Video Helper
 * Adheres strictly to the DRY (Don't Repeat Yourself) principle.
 * Used across MediaGalleryModal, DropzoneWrapper, CreateProduct, and UpdateProduct.
 */

/**
 * Extracts a YouTube Video ID from any URL or raw string.
 * Supports: watch?v=, youtu.be/, embed/, shorts/, live/, youtube-nocookie.com, img.youtube.com, etc.
 * @param {string|object} url
 * @returns {string|null}
 */
export function extractYouTubeId(url) {
  if (!url) return null;
  if (typeof url !== 'string') {
    if (typeof url === 'object') {
      url = url.rawUrl || url.videoUrl || url.url || url.image || url.src || url.previewUrl || '';
    }
    if (typeof url !== 'string') return null;
  }
  const clean = url.trim();
  if (!clean) return null;

  // 1. Exact 11-character YouTube video ID
  if (/^[a-zA-Z0-9_-]{11}$/.test(clean)) {
    return clean;
  }

  // 2. Standard watch URL (watch?v=ID or watch?feature=share&v=ID) or youtu.be
  const watchMatch = clean.match(/(?:youtu\.be\/|(?:www\.|m\.)?youtube(?:-nocookie)?\.com\/(?:.*[?&]v=|(?:v|e(?:mbed)?)\/))([^"&?\/\s]{11})/i);
  if (watchMatch && watchMatch[1]) {
    return watchMatch[1];
  }

  // 3. Shorts / Live / vi / embed
  const altMatch = clean.match(/(?:youtube(?:-nocookie)?\.com\/(?:shorts\/|live\/|vi\/|embed\/))([^"&?\/\s]{11})/i);
  if (altMatch && altMatch[1]) {
    return altMatch[1];
  }

  // 4. Image thumbnails: img.youtube.com/vi/ID/... or i.ytimg.com/vi/ID/...
  const thumbMatch = clean.match(/(?:img\.youtube\.com|i\.ytimg\.com)\/vi\/([^"&?\/\s]{11})/i);
  if (thumbMatch && thumbMatch[1]) {
    return thumbMatch[1];
  }

  // 5. Generic fallback regex for any 11-char token after youtube/youtu.be path
  const genericMatch = clean.match(/(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:embed\/|v\/|watch\?.*v=|shorts\/|live\/))([\w-]{11})/i);
  if (genericMatch && genericMatch[1]) {
    return genericMatch[1];
  }

  return null;
}

/**
 * Extracts a Vimeo Video ID from any URL or raw string.
 * @param {string|object} url
 * @returns {string|null}
 */
export function extractVimeoId(url) {
  if (!url) return null;
  if (typeof url !== 'string') {
    if (typeof url === 'object') {
      url = url.rawUrl || url.videoUrl || url.url || url.image || url.src || url.previewUrl || '';
    }
    if (typeof url !== 'string') return null;
  }
  const clean = url.trim();
  if (!clean) return null;
  if (/^\d{7,12}$/.test(clean)) return clean;
  const match = clean.match(/(?:vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/)?|player\.vimeo\.com\/video\/|vumbnail\.com\/|vimeocdn\.com\/video\/)(\d+)/i);
  return match ? match[1] : null;
}

/**
 * Checks if a given item or URL is a YouTube video.
 * @param {string|object} item
 * @returns {boolean}
 */
export function isYouTubeMedia(item) {
  if (!item) return false;
  if (typeof item === 'object') {
    if (item.file_type === 'youtube' || item.videoType === 'youtube') return true;
    const target = (item.rawUrl || item.videoUrl || item.image || item.src || item.url || item.name || item.file?.name || '').toLowerCase();
    if (target.includes('youtube') || target.includes('youtu.be') || target.includes('ytimg.com')) {
      return true;
    }
    return Boolean(extractYouTubeId(target));
  }
  const clean = String(item).toLowerCase();
  return clean.includes('youtube') || clean.includes('youtu.be') || clean.includes('ytimg.com') || Boolean(extractYouTubeId(clean));
}

/**
 * Checks if a given item or URL is a Vimeo video.
 * @param {string|object} item
 * @returns {boolean}
 */
export function isVimeoMedia(item) {
  if (!item) return false;
  if (typeof item === 'object') {
    if (item.file_type === 'vimeo' || item.videoType === 'vimeo') return true;
    const target = (item.rawUrl || item.videoUrl || item.image || item.src || item.url || item.name || item.file?.name || '').toLowerCase();
    if (target.includes('vimeo') || target.includes('vumbnail') || target.includes('vimeocdn')) {
      return true;
    }
    return Boolean(extractVimeoId(target));
  }
  const clean = String(item).toLowerCase();
  return clean.includes('vimeo') || clean.includes('vumbnail') || clean.includes('vimeocdn') || Boolean(extractVimeoId(clean));
}

/**
 * Gets high-quality thumbnail URL for a YouTube video.
 * @param {string} url
 * @returns {string}
 */
export function getYouTubeThumb(url) {
  const id = extractYouTubeId(url);
  return id ? `https://img.youtube.com/vi/${id}/hqdefault.jpg` : '/themes/default/assets/img/photograph.webp';
}

/**
 * Gets thumbnail URL for a Vimeo video.
 * @param {string} url
 * @returns {string}
 */
export function getVimeoThumb(url) {
  const id = extractVimeoId(url);
  return id ? `https://vumbnail.com/${id}.jpg` : '/themes/default/assets/img/photograph.webp';
}

/**
 * Normalizes dynamic resized image URLs (/image/{w}/{h}/{fmt}/{path})
 * or cached paths back to the full-resolution original path (/storage/{path}).
 * @param {string|object} item
 * @returns {string}
 */
export function getRealFullImageUrl(item) {
  if (!item) return '';

  if (typeof item === 'object') {
    if (item.file instanceof File) {
      return item.src || URL.createObjectURL(item.file);
    }
    if (item instanceof File) {
      return URL.createObjectURL(item);
    }
  }

  const rawUrl = typeof item === 'string' ? item : (item.src || item.url || '');
  if (typeof rawUrl !== 'string' || !rawUrl.trim()) return '';

  const trimmed = rawUrl.trim();

  // 1. Dynamic resize route: /image/{w}/{h}/{fmt}/{path}
  const resizeMatch = trimmed.match(/^(https?:\/\/[^\/]+)?\/(?:image|image_url)\/\d+\/\d+\/[a-zA-Z0-9_-]+\/(.+)$/i);
  if (resizeMatch) {
    const origin = resizeMatch[1] || '';
    const originalPath = resizeMatch[2];
    const normalized = originalPath.replace(/^\/+/, '');
    return origin ? `${origin}/${normalized}` : `/${normalized}`;
  }

  // 2. Cache route: /cache/{w}/{h}/{fmt}/{path}
  const cacheMatch = trimmed.match(/^(https?:\/\/[^\/]+)?\/cache\/\d+\/\d+\/[a-zA-Z0-9_-]+\/(.+)$/i);
  if (cacheMatch) {
    const origin = cacheMatch[1] || '';
    const originalPath = cacheMatch[2];
    const normalized = originalPath.replace(/^\/+/, '');
    return origin ? `${origin}/${normalized}` : `/${normalized}`;
  }

  return trimmed;
}

/**
 * Universal video source detector (YouTube, Vimeo, MP4, WebM, MOV, OGG, MKV).
 * Returns metadata object with embed URL and preview thumbnail.
 * @param {string} url
 * @returns {{type: string, id: string|null, embedUrl: string, previewUrl: string, title: string}|null}
 */
export function detectVideoSource(url) {
  if (!url || typeof url !== 'string') return null;
  const cleanUrl = url.trim();

  // 1. YouTube
  const ytId = extractYouTubeId(cleanUrl);
  if (ytId) {
    return {
      type: 'youtube',
      id: ytId,
      embedUrl: `https://www.youtube-nocookie.com/embed/${ytId}?autoplay=1&rel=0`,
      previewUrl: `https://img.youtube.com/vi/${ytId}/hqdefault.jpg`,
      title: `YouTube (${ytId})`
    };
  }

  // 2. Vimeo
  const vmId = extractVimeoId(cleanUrl);
  if (vmId) {
    return {
      type: 'vimeo',
      id: vmId,
      embedUrl: `https://player.vimeo.com/video/${vmId}?autoplay=1`,
      previewUrl: `https://vumbnail.com/${vmId}.jpg`,
      title: `Vimeo (${vmId})`
    };
  }

  // 3. Direct HTML5 Video link (MP4, WebM, OGG, MOV, MKV)
  if (/\.(mp4|webm|ogg|mov|mkv)(\?.*)?$/i.test(cleanUrl)) {
    return {
      type: 'video',
      id: null,
      embedUrl: cleanUrl,
      previewUrl: cleanUrl,
      title: cleanUrl.split('/').pop()?.split('?')[0] || 'Direct Video'
    };
  }

  // 4. Any other valid video link
  if (/^https?:\/\//i.test(cleanUrl)) {
    return {
      type: 'video',
      id: null,
      embedUrl: cleanUrl,
      previewUrl: cleanUrl,
      title: cleanUrl
    };
  }

  return null;
}

/**
 * Computes a unique, canonical identity key for a media item.
 * Guarantees that whether an item is passed as a 120x120 thumbnail URL,
 * a raw /storage/... URL, a YouTube watch URL, or a File object,
 * it maps to the exact same canonical key, completely preventing duplicates.
 * @param {any} item
 * @returns {string}
 */
export function getMediaCanonicalKey(item) {
  if (!item) return '';

  const rawUrl = typeof item === 'string' 
    ? item 
    : (item.rawUrl || item.videoUrl || item.image || item.url || item.src || item.rawSrc || item.fallbackSrc || item.previewUrl || '');

  // 1. YouTube Video canonical key
  const ytId = extractYouTubeId(rawUrl) || (item && typeof item === 'object' && item.youtubeId ? item.youtubeId : null);
  if (ytId) return `youtube::${ytId}`;

  // 2. Vimeo Video canonical key
  const vmId = extractVimeoId(rawUrl) || (item && typeof item === 'object' && item.vimeoId ? item.vimeoId : null);
  if (vmId) return `vimeo::${vmId}`;

  // 3. Local File object
  if (item && item.file instanceof File) {
    return `file::${item.file.name}_${item.file.size}`;
  }
  if (item instanceof File) {
    return `file::${item.name}_${item.size}`;
  }

  // 4. Image or Video URL (strip domain, resize path, and query parameters)
  if (typeof rawUrl === 'string' && rawUrl.trim()) {
    const realUrl = getRealFullImageUrl(typeof item === 'object' ? item : { src: rawUrl });
    const cleanPath = (realUrl || rawUrl)
      .trim()
      .replace(/^https?:\/\/[^\/]+/, '')
      .split('?')[0]
      .replace(/^\/+/, '');
    if (cleanPath) return `path::${cleanPath}`;
  }

  // 5. Fallback object identifier
  if (item && typeof item === 'object') {
    if (item.id) return `id::${item.id}`;
    if (item.name) return `name::${item.name}`;
  }

  return '';
}
